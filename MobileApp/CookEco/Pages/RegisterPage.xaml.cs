using CookEco.Services;
using CookEco.Models;
namespace CookEco;
public partial class RegisterPage : ContentPage
{
    public RegisterPage()
    {
        InitializeComponent();
    }

    private async void OnRegisterClicked(object sender, EventArgs e)
    {
        await ManagerDB.Init();

        var user = new User
        {
            Username = UsernameEntry.Text,
            Password = PasswordEntry.Text
        };
        await ManagerDB.SaveUserAsync(user);
        await DisplayAlert("Success", "User registered", "OK");
        await Navigation.PopAsync(); 
    }

    private async void OnLoginClicked(object sender, EventArgs e)
    {
        await Navigation.PopAsync(); 
    }
}