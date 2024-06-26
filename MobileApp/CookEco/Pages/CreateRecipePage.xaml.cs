using System;
using System.IO;
using System.Threading.Tasks;
using CookEco.Services;
using CookEco.Models;
using Microsoft.Maui.Media;

namespace CookEco
{
    public partial class CreateRecipePage : ContentPage
    {
        public static string localFilePath;

        public CreateRecipePage()
        {
            InitializeComponent();
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
            await DisplayAlert("Success", "Recipe saved", "OK");
            await Navigation.PopAsync();
        }
    }
}