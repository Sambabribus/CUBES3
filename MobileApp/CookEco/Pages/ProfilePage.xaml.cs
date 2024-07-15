using CookEco.Models;
using CookEco.Services;
using Microsoft.Maui.Controls;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;

namespace CookEco
{
    public partial class ProfilePage : ContentPage
    {
        private int CurrentUserId;

        public ProfilePage()
        {
            InitializeComponent();
            // This constructor will be used when no parameter is provided.
            LoadUserData();
        }

        public ProfilePage(int userId) : this()
        {
            CurrentUserId = userId;
            LoadUserData();
        }

        private async void LoadUserData()
        {
            await ManagerDB.Init();

            // Якщо ідентифікатор користувача не був встановлений через параметризований конструктор, спробуйте отримати його з сесії або іншого зберігання.
            if (CurrentUserId == 0)
            {
                CurrentUserId = ((App)Application.Current).CurrentUserId;
            }

            var user = await ManagerDB.GetUserByIdAsync(CurrentUserId);
            if (user != null)
            {
                UsernameLabel.Text = user.Username;
                var recipes = await GetUserRecipesAsync(CurrentUserId);
                LoadRecipesToUI(recipes);
            }
        }

        private async Task<List<Recipe>> GetUserRecipesAsync(int userId)
        {
            await ManagerDB.Init();
            var userRecipes = await ManagerDB.GetRecipesByUserIdAsync(userId);
            return userRecipes;
        }

        private void LoadRecipesToUI(List<Recipe> recipes)
        {
            foreach (var recipe in recipes)
            {
                var recipeFrame = new Frame
                {
                    BackgroundColor = Color.FromHex("#FFFFFF"),
                    Padding = 10,
                    CornerRadius = 10,
                    BorderColor = Color.FromHex("#D0D0D0"),
                    Margin = new Thickness(0, 0, 0, 10),
                    Content = new StackLayout
                    {
                        Spacing = 10,
                        Children =
                        {
                            new Image
                            {
                                Source = recipe.FullImagePath,
                                HeightRequest = 150,
                                HorizontalOptions = LayoutOptions.Center,
                                VerticalOptions = LayoutOptions.Center,
                                Aspect = Aspect.Fill
                            },
                            new Label
                            {
                                Text = "Ingrédients",
                                FontSize = 18,
                                FontAttributes = FontAttributes.Bold,
                                TextColor = Color.FromHex("#a17c5e")
                            },
                            new Label
                            {
                                Text = recipe.Description,
                                FontSize = 14,
                                TextColor = Color.FromHex("#000000")
                            },
                            new Label
                            {
                                Text = "Préparation de la recette",
                                FontSize = 18,
                                FontAttributes = FontAttributes.Bold,
                                TextColor = Color.FromHex("#a17c5e")
                            },
                            new Label
                            {
                                Text = recipe.PreparationTime.ToString(),
                                FontSize = 14,
                                TextColor = Color.FromHex("#000000")
                            }
                        }
                    }
                };

                UserRecipesStackLayout.Children.Add(recipeFrame);
            }
        }
    }
}
