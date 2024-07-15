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
            if (!string.IsNullOrEmpty(localFileName))
            {
                RecipeImage.Source = ImageSource.FromFile(localFileName);
            }
        }


        private async Task<string> CapturePhotoAsync()
        {
            if (MediaPicker.Default.IsCaptureSupported)
            {
                FileResult photo = await MediaPicker.Default.CapturePhotoAsync();

                if (photo != null)
                {
                    var newFile = Path.Combine(FileSystem.AppDataDirectory, photo.FileName);
                    using (var stream = await photo.OpenReadAsync())
                    using (var newStream = File.OpenWrite(newFile))
                        await stream.CopyToAsync(newStream);

                    return newFile;
                }
            }
            return null;
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
                LocalImagePath = localFileName
            };

            var existingRecipe = await ManagerDB.GetRecipeByIdAsync(recipe.Id);
            if (existingRecipe == null)
            {
                await ManagerDB.SaveRecipeAsync(recipe);
                _recipes?.Add(recipe);

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
    }
}
