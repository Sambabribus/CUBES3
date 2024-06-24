namespace CookEco
{
    public partial class CreateRecipePage : ContentPage
    {
        public CreateRecipePage()
        {
            InitializeComponent();
        }

        private async void OnSaveRecipeClicked(object sender, EventArgs e)
        {
            await ManagerDB.Init();

            var recipe = new Recipe
            {
                Title = TitleEntry.Text,
                Description = DescriptionEntry.Text,
                ImagePath = ImagePathEntry.Text
            };
            await ManagerDB.SaveRecipeAsync(recipe);
            await DisplayAlert("Success", "Recipe saved", "OK");
            await Navigation.PopAsync();
        }
    }
}