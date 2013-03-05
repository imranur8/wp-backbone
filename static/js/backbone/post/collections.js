/**
 *  @package wp-backbone-plugin
 *  @author  Md Imranur Rahman <imran.aspire@gmail.com>
 *
 *  define backbone collection
 **/


App.Posts = Backbone.Collection.extend({
    url: App.domain + "/api/mypost/",
    model: App.Post
});
