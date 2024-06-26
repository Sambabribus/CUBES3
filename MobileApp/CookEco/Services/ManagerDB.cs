using SQLite;
using System.IO;
using System.Threading.Tasks;
using CookEco.Models;

namespace CookEco.Services
{
    public static class ManagerDB
    {
        private static SQLiteAsyncConnection _database;

        public static async Task Init()
        {
            if (_database != null)
                return;

            var databasePath = Path.Combine(FileSystem.AppDataDirectory, "recipes.db");
            Console.WriteLine(databasePath);
            _database = new SQLiteAsyncConnection(databasePath);
            await _database.CreateTableAsync<User>();
            await _database.CreateTableAsync<Recipe>();
        }

        public static Task<int> SaveUserAsync(User user) => _database.InsertAsync(user);
        public static Task<User> GetUserAsync(string username) => _database.Table<User>().FirstOrDefaultAsync(u => u.Username == username);

        public static Task<int> SaveRecipeAsync(Recipe recipe) => _database.InsertAsync(recipe);
        public static Task<List<Recipe>> GetRecipesAsync() => _database.Table<Recipe>().ToListAsync();
    }
}