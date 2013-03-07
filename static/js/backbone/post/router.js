/**
 *  @package wp-backbone
 *  @author  Md Imranur Rahman <imran.aspire@gmail.com>
 *
 *  backbone post router
 **/


App.PostRouter = Backbone.Router.extend({
    routes: {
        '': 'listPosts',
        'post/:slug': 'postDetail',
        'edit/:slug': 'postEdit',
        'add': 'postEdit'
    },
    initialize: function() {
        console.log('Intializing MyPost router');
        _.bindAll(this, "listPosts");
        this.$el = $("#wfp_backbone_shortcode");

    },
    listPosts: function(){
        currentView = this;
        if(App.postList){
            var  listpostView = new App.PostListView({collection:App.postList});
            currentView.$el.html(listpostView.render().el);
        }else{
            App.postList = new App.Posts();
            App.postList.fetch().then(function(){
                var  listpostView = new App.PostListView({collection:App.postList});
                currentView.$el.html(listpostView.render().el);
            });
        }
    },
    postDetail: function(slug){
        currentView = this;
        if(App.postList){
            var post = App.postList.where({post_name:slug})[0];
            if(post){
                var  postDetailView = new App.PostDetailView({model:post})
                currentView.$el.html(postDetailView.render().el);
            }
        }else{
            App.myPost = new App.Post({post_name:slug});
            App.myPost.sync('get', App.myPost, {
                success: function(response){
                    var  postDetailView = new App.PostDetailView({model:App.myPost})
                    currentView.$el.html(postDetailView.render().el);
                }
            })
        }
    },
    postEdit: function(slug){
        currentView = this;
        if(App.postList){
            var post = App.postList.where({post_name:slug})[0];
            if(post){
                var  postEditView = new App.PostEditView({model:post})
                currentView.$el.html(postEditView.render().el);
            }
            else{
                var  postEditView = new App.PostEditView({model:new App.Post({status:"Add"})})
                currentView.$el.html(postEditView.render().el);
            }
        }
        else if(App.myPost){
            var  postEditView = new App.PostEditView({model:App.myPost})
            currentView.$el.html(postEditView.render().el);
        }
    }
});