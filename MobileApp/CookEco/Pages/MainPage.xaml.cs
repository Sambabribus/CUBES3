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

        private async void PickImage(object sender, EventArgs e)
        {

            var result = await FilePicker.PickAsync(new PickOptions
            {
                PickerTitle = "Pick Image Please",
                FileTypes = FilePickerFileType.Images
            });

            if (result == null)
            {
                return;
            }

            var stream = await result.OpenReadAsync();
            myImage.Source = ImageSource.FromStream(() => stream);
        }
    }
}