using System;
using System.Net.Http;
using System.Net.Http.Json;
using System.Threading.Tasks;
using CookEco.Models;

namespace CookEco.Services
{
    internal class FetchUserPassword
    {
        private readonly HttpClient _http;

        public FetchUserPassword()
        {
            _http = new HttpClient();
            _http.BaseAddress = new Uri("http://172.27.144.1/");
        }

        public async Task<UsersResponse> GetUsersResponse()
        {
            try
            {
                var usersResponse = await _http.GetFromJsonAsync<UsersResponse>("/API/CUBES3/CUBES3-api/index.php/users");
                return usersResponse;
            }
            catch (Exception ex)
            {
                Console.WriteLine("Error fetching users data: " + ex.Message);
                return null;
            }
        }

        public User MapUser(User user)
        {
            return new User
            {
                Id = user.Id,
                Username = user.Username,
                Password = user.Password
            };
        }
    }
}