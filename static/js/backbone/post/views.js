
/**
 *  @package wp-backbone
 *  @author  Md Imranur Rahman <imran.aspire@gmail.com>
 *
 *  backbone post views
 **/

/**
 *  single list post view
 */

App.PostView = Backbone.View.extend({
    className: "wbf-post-view",
    template: _.template(App.template("post")),
    initialize: function(){
        _.bindAll(this,"render", "deletePost", "ondeleteSuccess");
        this.render();
    },
    events:{
        "click .delete" : "deletePost"
    },
    render:function(){
        var context = {
            model: this.model.toJSON(),
            isLogin: App.isLogin
        };
        this.$el.html(this.template(context));
        return this;
    },
    deletePost:function(e){
        e.preventDefault();
        var chk = confirm("Are you sure to Delete this Post ?");
        if(chk == true){
            this.model.destroy({
                success: this.ondeleteSuccess
            })
        }
    },
    ondeleteSuccess: function(model, response){
        this.$el.remove();
    }
});

/**
 *  all list post view
 * @type {*}
 */

App.PostListView = Backbone.View.extend({
    template:_.template(App.template("postlist")),
    initialize:function(){
        console.log("Initialize the POST list View ");
        _.bindAll(this, "render", "addOne")
        this.collection.on("reset",this.render())
        //console.log(this.template)
    },
    render:function(){
        //this.$el.html
        this.$el.html(this.template({isLogin: App.isLogin}));
        this.collection.each(this.addOne, this)
        return this;
    },
    addOne:function(post){

        var postView = new App.PostView({model:post});
        this.$el.find("#backbonePostList").append(postView.render().el);
        return this;
    }
});


/**
 *  post detail view
 * @type {*}
 */
App.PostDetailView = Backbone.View.extend({
    className: "wbf-post-view",
    template: _.template(App.template("post-detail")),
    events:{
        "click .delete" : "deletePost"
    },
    initialize: function(){

        console.log("Initialize the POST Detail View ");
        _.bindAll(this,"render" , "deletePost", "ondeleteSuccess");
        this.render();
    },
    render:function(){
        var context = {
            model: this.model.toJSON(),
            isLogin: App.isLogin
        };
        this.$el.html(this.template(context));
        return this;
    },
    deletePost:function(e){
        e.preventDefault();
        var chk = confirm("Are you sure to Delete this Post ?");
        if(chk == true){
            this.model.destroy({
                success: this.ondeleteSuccess
            })
        }
    },
    ondeleteSuccess: function(model, response){
        this.$el.remove();
        window.location.hash = '#';
    }
});

/**
 * post  add/edit  view
 * @type {*}
 */

App.PostEditView = Backbone.View.extend({
    className: "wbf-post-view",
    template: _.template(App.template("post-edit")),
    events: {
        "click .update" : "updatePost"
    },
    initialize: function(){
        console.log("Initialize the POST Edit View ");
        _.bindAll(this,"render", "updatePost");
        this.render();
    },
    render:function(){
        var context = {
            model: this.model.toJSON(),
            imageUrl : App.imageUrl
        };
        this.$el.html(this.template(context));
        return this;
    },
    updatePost: function(){

        var currentModel = this.model;
        App.imran = currentModel;
        console.log(currentModel)
        var currentView = this;

        // for update
        if(currentModel.get("status") == "Update"){
            currentView.$el.find(".wbf_loader").css("visibility", "visible");
            data = {
                title: this.$el.find(".title").val(),
                content: this.$el.find(".content").val(),
                post_excerpt: this.$el.find(".content").val().substring(0,200)
            }
            this.model.set(data);

            this.model.sync('update', this.model, {
                success: function(response){
                    currentView.$el.find(".wbf_loader").css("visibility", "hidden");
                    window.location.hash = 'post/'+currentModel.get("post_name");
                }
            })

        }
        else{
            currentView.$el.find(".wbf_loader").css("visibility", "visible");
            data = {
                title: this.$el.find(".title").val(),
                content: this.$el.find(".content").val(),
                post_excerpt: this.$el.find(".content").val().substring(0,200)
            }
            this.model.set(data);
            this.model.sync('create', this.model, {
                success: function(response){
                    App.postList.add(currentModel);
                    currentView.$el.find(".wbf_loader").css("visibility", "hidden");
                    window.location.hash = 'post/'+currentModel.get("post_name");
                }
            })

        }


    }
});

