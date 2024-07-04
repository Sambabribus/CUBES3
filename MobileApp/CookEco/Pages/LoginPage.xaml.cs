using CookEco.Models;
using CookEco.Services;
using Microsoft.Maui.Controls;
using System;
using System.Linq;
using System.Threading.Tasks;
using BCrypt.Net;
using static CookEco.Services.FetchUserPassword;

namespace CookEco
{
    public partial class LoginPage : ContentPage
    {
        private FetchUserPassword _fetchUserPassword;

        public LoginPage()
        {
            InitializeComponent();
            _fetchUserPassword = new FetchUserPassword();
            LoadApiDataAsync();
        }

        private async Task LoadApiDataAsync()
        {
            var usersResponse = await _fetchUserPassword.GetUsersResponse();
            if (usersResponse != null && usersResponse.Records != null)
            {
                API_FILD.Text = string.Join("\n", usersResponse.Records.Select(u => u.Username));
            }
            else
            {
                API_FILD.Text = "Failed to retrieve users list.";
            }
        }

        private async void OnLoginClicked(object sender, EventArgs e)
        {
            var usersResponse = await _fetchUserPassword.GetUsersResponse();
            if (usersResponse?.Records != null)
            {
                Console.WriteLine("Users list retrieved successfully.");
                var user = usersResponse.Records.FirstOrDefault(u => u.Username == UsernameEntry.Text);

                if (user != null)
                {
                    Console.WriteLine($"User found: {user.Username}");
                    Console.WriteLine($"Stored Hashed Password: {user.Password}");

                    if (BCrypt.Net.BCrypt.Verify(PasswordEntry.Text, user.Password))
                    {
                        await DisplayAlert("Success", "Login successful", "OK");
                        ((App)Application.Current).LoginSuccessful();
                        return;
                    }
                    else
                    {
                        Console.WriteLine("Password verification failed.");
                        await DisplayAlert("Error", "Incorrect password.", "OK");
                    }
                }
                else
                {
                    Console.WriteLine("User not found.");
                    await DisplayAlert("Error", "User not found.", "OK");
                }
            }
            else
            {
                Console.WriteLine("Failed to retrieve users list.");
                await DisplayAlert("Error", "Failed to retrieve users list.", "OK");
            }
        }

        private async void OnRegisterClicked(object sender, EventArgs e)
        {
            await Navigation.PushAsync(new RegisterPage());
        }

        private async void OnShowApiDataClicked(object sender, EventArgs e)
        {
            var usersResponse = await _fetchUserPassword.GetUsersResponse();
        }
    }
}