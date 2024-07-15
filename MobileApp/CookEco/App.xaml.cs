namespace CookEco
{
    public partial class App : Application
    {
        public int CurrentUserId { get; set; }

        public App()
        {
            InitializeComponent();
            MainPage = new NavigationPage(new LoginPage());
        }

        public void LoginSuccessful(int userId)
        {
            CurrentUserId = userId;
            MainPage = new AppShell();
        }
    }
}
