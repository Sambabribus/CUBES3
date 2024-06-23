namespace CookEco;
public partial class LoginPage : ContentPage
{
    public LoginPage()
    {
        InitializeComponent();
    }

    private async void OnLoginClicked(object sender, EventArgs e)
    {
        await ManagerDB.Init();

        var user = await ManagerDB.GetUserAsync(UsernameEntry.Text);
        if (user != null && user.Password == PasswordEntry.Text)
        {
            await DisplayAlert("Success", "Login successful", "OK");
            await Navigation.PushAsync(new MainPage());
        }
        else
        {
            await DisplayAlert("Error", "Invalid username or password", "OK");
        }
    }

    private async void OnRegisterClicked(object sender, EventArgs e)
    {
        await Navigation.PushAsync(new RegisterPage());
    }
}