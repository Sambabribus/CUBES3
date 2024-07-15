using System;
using System.Collections.ObjectModel;
using Microsoft.Maui.Controls;
using CookEco.Models;
using CookEco.Services;
using System.IO;
using System.Threading.Tasks;
using Microsoft.Maui.Media;
using System.Net.Http;
using System.Text;
using System.Text.Json;

namespace CookEco
{
    public partial class CreateRecipePage : ContentPage
    {
        private ObservableCollection<Recipe> _recipes;
        public static string localFileName;

        public CreateRecipePage()
        {
            InitializeComponent();
        }

        public CreateRecipePage(ObservableCollection<Recipe> recipes) : this()
        {
            _recipes = recipes;
        }

        private async void TakePhoto(object sender, EventArgs e)
        {
            localFileName = await CapturePhotoAsync();
        }

        private async Task<string> CapturePhotoAsync()
        {
            if (MediaPicker.Default.IsCaptureSupported)
            {
                FileResult photo = await MediaPicker.Default.CapturePhotoAsync();

                if (photo != null)
                {
                    return photo.FileName; 
                }
                else
                {
                    return "no_image_name";
                }
            }
            else
            {
                return "no_image_name";
            }
        }

        private async void OnSaveRecipeClicked(object sender, EventArgs e)
        {
            await ManagerDB.Init();

            var recipe = new Recipe
            {
                Title = TitleEntry.Text,
                Description = DescriptionEntry.Text,
                PreparationTime = int.Parse(PreparationTimeEntry.Text),
                CookingTime = int.Parse(CookingTimeEntry.Text),
                Serves = int.Parse(ServesEntry.Text),
                CreationDate = DateTime.Now.ToString("yyyy-MM-dd HH:mm:ss"),
                ImagePath = localFileName 
            };

            var existingRecipe = await ManagerDB.GetRecipeByIdAsync(recipe.Id);
            if (existingRecipe == null)
            {
                await ManagerDB.SaveRecipeAsync(recipe);
                _recipes?.Add(recipe);
                //await SendRecipeToAPI(recipe);

                await DisplayAlert("Success", "Recipe saved", "OK");
            }
            else
            {
                await DisplayAlert("Error", "Recipe already exists", "OK");
            }

            await Navigation.PopAsync();
        }

        public void SetRecipesCollection(ObservableCollection<Recipe> recipes)
        {
            _recipes = recipes;
        }

       /* private async Task SendRecipeToAPI(Recipe recipe)
        {
            using var httpClient = new HttpClient { BaseAddress = new Uri("http://api.snsekken.com") };
            var json = JsonSerializer.Serialize(new { records = new[] { recipe } });
            var content = new StringContent(json, Encoding.UTF8, "application/json");
            var response = await httpClient.PostAsync("/index.php/recipes", content);

            var responseContent = await response.Content.ReadAsStringAsync();
            Console.WriteLine($"Response: {responseContent}");  

            response.EnsureSuccessStatusCode();
        }*/
    }
}