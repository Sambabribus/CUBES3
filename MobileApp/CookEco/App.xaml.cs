namespace CookEco
{
    public partial class App : Application
    {
        public App()
        {
            InitializeComponent();
            MainPage = new NavigationPage(new LoginPage());
        }

        public void LoginSuccessful()
        {
            MainPage = new AppShell();
        }
    }
}