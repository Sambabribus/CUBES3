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
            await _database.CreateTableAsync<Comment>();
        }

        public static Task<int> SaveUserAsync(User user) => _database.InsertAsync(user);
        public static Task<User> GetUserAsync(string username) => _database.Table<User>().FirstOrDefaultAsync(u => u.Username == username);

        public static async Task<int> SaveRecipeAsync(Recipe recipe)
        {
            var existRecipe = await _database.Table<Recipe>().FirstOrDefaultAsync(r => r.Id == recipe.Id);
            if (existRecipe == null)
            {
                return await _database.InsertAsync(recipe);
            }
            return 0;
        }

        public static Task<Recipe> GetRecipeByIdAsync(int id) => _database.Table<Recipe>().FirstOrDefaultAsync(r => r.Id == id);

        public static Task<List<Recipe>> GetRecipesAsync() => _database.Table<Recipe>().ToListAsync();

        public static Task<int> SaveCommentAsync(Comment comment) => _database.InsertAsync(comment);
        public static Task<List<Comment>> GetCommentsAsync() => _database.Table<Comment>().ToListAsync();

        public static Task ClearAllDataAsync()
        {
            return Task.WhenAll(
                _database.DeleteAllAsync<User>(),
                _database.DeleteAllAsync<Recipe>(),
                _database.DeleteAllAsync<Comment>()
            );
        }
    }
}