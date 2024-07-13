using CookEco.Models;
using CookEco.Services;
using Microsoft.Maui.Controls;
using System;
using System.Linq;
using System.Threading.Tasks;
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
            await ManagerDB.Init();

            var localUser = await ManagerDB.GetUserAsync(UsernameEntry.Text);
            if (localUser != null && PasswordEntry.Text == localUser.Password && UsernameEntry.Text == localUser.Username)
            {
                await DisplayAlert("Success", "Login successful", "OK");
                ((App)Application.Current).LoginSuccessful();
                return;
            }
            try
            {
                var usersResponse = await _fetchUserPassword.GetUsersResponse();
                if (usersResponse?.Records != null)
                {
                    Console.WriteLine("Users list retrieved successfully.");
                    var apiUser = usersResponse.Records.FirstOrDefault(u => u.Username == UsernameEntry.Text);
                    if (apiUser != null && PasswordEntry.Text == apiUser.Password)
                    {
                        await DisplayAlert("Success", "Login successful", "OK");
                        ((App)Application.Current).LoginSuccessful();
                        return;
                    }
                }
                else
                {
                    Console.WriteLine("Failed to retrieve users list.");
                }
            }
            catch (Exception ex)
            {
                Console.WriteLine($"API connection failed: {ex.Message}");
            }

            await DisplayAlert("Error", "Incorrect username or password.", "OK");
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