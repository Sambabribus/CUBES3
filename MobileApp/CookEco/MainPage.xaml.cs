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
    }

}
