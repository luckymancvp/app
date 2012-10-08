/**
 * Created with JetBrains PhpStorm.
 * User: luckymancvp
 * Date: 9/27/12
 * Time: 1:27 PM
 * To change this template use File | Settings | File Templates.
 */

$(document).ready(function(){
    var itemsJSON = [];

    $(".modal").hide();

    // Tabs
    $('.demoTabs a').click(function (e) {
        e.preventDefault();
        $(this).tab('show');
    });
    //$("[href=#block]").click();

    $("#blocktext-input").focus();


    $("#import-item").click(function(e){
        e.preventDefault();

        $.ajax({
            url : importtextUrl,
            type: "POST",
            data:{
                "blocktext": $("#blocktext-input").val()
            },
            success: function(res){

                itemsJSON = res;
                masterView = new MasterView();
            }

        });
    });

    // Backbone
    var Item = Backbone.Model.extend({
    });

    var Items = Backbone.Collection.extend({
        model : Item
    });

    var ItemView = Backbone.View.extend({
        template     : $("#wordTemplate").html(),

        events : {
            "click .word": "pop"
        },

        render: function(){
            var tmpl = _.template(this.template);
            this.$el.html(tmpl(this.model.toJSON()));
            return this;
        },

        pop : function(e){
            e.preventDefault();

            console.log("a");
            this.$el.find(".word").popover("show");
        }
    })

    MasterView = Backbone.View.extend({
        el           : "#response",

        initialize: function(){
            this.collection = new Items(itemsJSON);

            //Add event listener
            this.collection.on("add", this.renderItem, this);
            this.render();
        },

        render: function(){
            var that = this;
            _.each(this.collection.models, function(item){
                that.renderItem(item);
            });
        },

        renderItem: function(item){
            var itemView = new ItemView({model : item});

            this.$el.append(itemView.render().$el);
        }

    });


    itemsJSON = [{"iphone":""},{"quick":""},{"tip":""},{"how":""},{"to":""},{"add":""},{"letterboxing":""},{"back":""},{"your":""},{"ios":""},{"app":""},{"so":""},{"you've":""},{"removed":""},{"from":""},{"by":""},{"adding":""},{"a":""},{"default-568h@2x.png":""},{"launch":""},{"image":""},{"and":""},{"there":""},{"was":""},{"much":""},{"rejoicing":""},{"except":""},{"now":""},{"all":""},{"of":""},{"layouts":""},{"are":""},{"messed":""},{"up":""},{"and":""},{"you're":""},{"supposed":""},{"push":""},{"an":""},{"update":""},{"through":""},{"the":""},{"store":""},{"tomorrow":""},{"you":""},{"delete":""},{"and...nothing":""},{"your":""},{"still":""},{"seems":""},{"be":""},{"running":""},{"in":""},{"full-screen":""},{"mode":""},{"what's":""},{"deal":""},{"it":""},{"bug":""},{"but":""},{"is":""},{"workaround":""},{"here":""},{"steps":""},{"that":""},{"i":""},{"went":""},{"re-enable":""},{"xcode":""},{"remove":""},{"run":""},{"clean":""},{"build":""},{"folder":""},{"uninstall":""},{"device/simulator":""},{"run":""},{"it's":""},{"not":""},{"immediately":""},{"clear":""},{"me":""},{"why":""},{"have":""},{"jump":""},{"so":""},{"many":""},{"hoops":""},{"it":""},{"might":""},{"caching":""},{"intermediate":""},{"version":""},{"resource":""},{"build":""},{"folder":""},{"simultaneously":""},{"this":""},{"memory":""},{"or":""},{"on":""},{"disk":""},{"i'll":""},{"if":""},{"get":""},{"more":""},{"information":""}];
    masterView = new MasterView();

});