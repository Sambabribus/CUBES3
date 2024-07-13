using System;
using System.Collections.ObjectModel;
using Microsoft.Maui.Controls;
using CookEco.Models;
using CookEco.Services;
using System.IO;
using System.Threading.Tasks;
using Microsoft.Maui.Media;

namespace CookEco
{
    public partial class CreateRecipePage : ContentPage
    {
        private ObservableCollection<Recipe> _recipes;
        public static string localFilePath;

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
            localFilePath = await CapturePhotoAsync();
        }

        private async Task<string> CapturePhotoAsync()
        {
            if (MediaPicker.Default.IsCaptureSupported)
            {
                FileResult photo = await MediaPicker.Default.CapturePhotoAsync();

                if (photo != null)
                {
                    string localFilePath = Path.Combine(FileSystem.CacheDirectory, photo.FileName);
                    using Stream sourceStream = await photo.OpenReadAsync();
                    using FileStream localFileStream = File.OpenWrite(localFilePath);
                    await sourceStream.CopyToAsync(localFileStream);
                    return localFilePath ?? "no_image_path";
                }
                else
                {
                    return "no_image_path";
                }
            }
            else
            {
                return "no_image_path";
            }
        }

        private async void OnSaveRecipeClicked(object sender, EventArgs e)
        {
            await ManagerDB.Init();

            var recipe = new Recipe
            {
                Title = TitleEntry.Text,
                Description = DescriptionEntry.Text,
                ImagePath = localFilePath
            };

            await ManagerDB.SaveRecipeAsync(recipe);
            _recipes?.Add(recipe);

            await DisplayAlert("Success", "Recipe saved", "OK");
            await Navigation.PopAsync();
        }

        public void SetRecipesCollection(ObservableCollection<Recipe> recipes)
        {
            _recipes = recipes;
        }
    }
}