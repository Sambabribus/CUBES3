using Microsoft.Maui.Storage; 
using Microsoft.Maui.Controls;
using CookEco.Services;
namespace CookEco
{
    public partial class MainPage : ContentPage
    {
        
        public MainPage()
        {
            InitializeComponent();
            LoadRecipes();
        }

        private async void LoadRecipes()
        {
            await ManagerDB.Init();
            var recipes = await ManagerDB.GetRecipesAsync();
            RecipeListView.ItemsSource = recipes;
        }

        private async void OnCreateRecipeClicked(object sender, EventArgs e)
        {
            await Navigation.PushAsync(new CreateRecipePage());
        }
    }
}