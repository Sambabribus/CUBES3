using CookEco.Models;
using CookEco.Services;
using Microsoft.Maui.Controls;
using System.Linq;
using System.Threading.Tasks;

namespace CookEco
{
    public partial class ProfilePage : ContentPage
    {
        public ProfilePage()
        {
            InitializeComponent();
            LoadUserData();
        }

        private async void LoadUserData()
        {
            await ManagerDB.Init();
            int currentUserId = ((App)Application.Current).CurrentUserId;

            var user = await ManagerDB.GetUserByIdAsync(currentUserId);
            if (user != null)
            {
                UsernameLabel.Text = user.Username;
            }
            else
            {
                UsernameLabel.Text = "User not found";
            }
        }
    }
}
