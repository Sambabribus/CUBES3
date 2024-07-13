using Microsoft.Maui.Controls;
using CookEco.Models;
using CookEco.Services;
using System.Collections.ObjectModel;
using System.Linq;
using System.Threading.Tasks;

namespace CookEco
{
    public partial class RecipeDetailPage : ContentPage
    {
        public ObservableCollection<Comment> Comments { get; set; }

        public RecipeDetailPage(Recipe selectedRecipe)
        {
            InitializeComponent();
            BindingContext = selectedRecipe;
            Comments = new ObservableCollection<Comment>();
            CommentsListView.ItemsSource = Comments;
            LoadComments(selectedRecipe.Id);
        }

        private async void LoadComments(int recipeId)
        {
            await ManagerDB.Init();
            var allComments = await ManagerDB.GetCommentsAsync();
            var recipeComments = allComments.Where(c => c.RecipeId == recipeId).ToList();
            foreach (var comment in recipeComments)
            {
                Comments.Add(comment);
            }
        }
    }
}