using CookEco.Models;
using CookEco.Services;
using Microsoft.Maui.Controls;
using System;
using System.Linq;
using System.Text.Json;
using System.Threading.Tasks;
using BCrypt.Net;

namespace CookEco
{
    public partial class LoginPage : ContentPage
    {
        private FetchUserPassword _fetchUserPassword;

        public LoginPage()
        {
            InitializeComponent();
            _fetchUserPassword = new FetchUserPassword();   
        }

        private async void OnLoginClicked(object sender, EventArgs e)
        {
            if (string.IsNullOrWhiteSpace(UsernameEntry.Text) || string.IsNullOrWhiteSpace(PasswordEntry.Text))
            {
                await DisplayAlert("Error", "Username and password are required", "OK");
                return;
            }

            try
            {
                var usersResponse = await _fetchUserPassword.GetUsersResponse();
                var user = usersResponse?.Records?.FirstOrDefault(u => u.Username == UsernameEntry.Text);

                if (user != null)
                {
                    Console.WriteLine($"Entered Username: {UsernameEntry.Text}");
                    Console.WriteLine($"Stored Hashed Password: {user.Password}");

                    if (BCrypt.Net.BCrypt.Verify(PasswordEntry.Text, user.Password))
                    {
                        HashedPasswordLabel.Text = $"Hashed Password: {user.Password}";
                        await DisplayAlert("Success", "Login successful", "OK");
                        ((App)Application.Current).LoginSuccessful();
                        return;
                    }
                }

                await DisplayAlert("Error", "Invalid username or password", "OK");
            }
            catch (Exception ex)
            {
                await DisplayAlert("Error", ex.Message, "OK");
            }
        }

        private async void OnRegisterClicked(object sender, EventArgs e)
        {
            await Navigation.PushAsync(new RegisterPage());
        }

        private async void OnShowApiDataClicked(object sender, EventArgs e)
        {
            try
            {
                var usersResponse = await _fetchUserPassword.GetUsersResponse();
                ApiDataEditor.Text = JsonSerializer.Serialize(usersResponse);
            }
            catch (Exception ex)
            {
                await DisplayAlert("Error", ex.Message, "OK");
            }
        }
    }
}
