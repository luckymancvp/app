/**
 * Created with JetBrains PhpStorm.
 * User: luckymancvp
 * Date: 10/1/12
 * Time: 2:57 PM
 * To change this template use File | Settings | File Templates.
 */

$(document).ready(function(){

    $("#quiz-progress").hide();
    // Event listener
    $("#start-quiz").click(function(){
        $("#quiz-setup").fadeOut("fast",function(){$("#quiz-progress").fadeIn("slow");});

        quizView.start();
        return false;
    });

    // Use backbone library
    var Item  = Backbone.Model.extend({
        defaults: {
            word: "",
            meaning : "",
            sound: ""
        }
    });

    var Items = Backbone.Collection.extend({
        model : Item
    });

    var QuizView = Backbone.View.extend({
        el             : "#quizZone",
        template       : $("#itemQuiz").html(),
        templateEnd    : $("#quizEnd").html(),
        templateAnswer : $("#quizAnswer").html(),
        events : {
            "click .yes"      : "yes",
            "click .no"       : "no",
            "click .ok"       : "render",
            "click .continue" : "continue"
        },
        loop  : 0,
        count : 0,
        next  : 0,
        orderedIems: new Array(),
        initialize: function(){
            this.collection = new Items(itemsJSON);
        },
        render       : function(){
            var progress = Math.round(this.next*1000.0 / this.count) / 10;
            $("#progress-bar").html(progress + "%");
            $("#progress-bar").attr("style","width: "+progress+"%");

            if (this.next == this.count){
                this.loop++;
                $("#loop").html(this.loop);
                this.renderEnd();
            }
            else
                this.renderQuiz(this.orderedItems[this.next++]);
        },
        'start': function(){
            this.order();

            // display init state
            $("#loop").html(0);
            $("#true").html(0);
            $("#wrong").html(0);
            $("#total").html(this.count);

            this.next    = 0; // next index item
            this.render();
        },
        order : function(){
            // init
            this.orderMode = "sequence";
            that = this;
            this.orderedItems = new Array();
            this.count = 0;
            switch (this.orderMode){
                case "sequence":
                    _.each(this.collection.models, function(item){
                        that.orderedItems[that.count++] = item;
                    });
                    break;
            }
        },
        renderQuiz : function(item){
            var tmpl = _.template(this.template);
            this.$el.html(tmpl(item.toJSON()));
            return this;
        },
        renderEnd : function(){
            var tmpl = _.template(this.templateEnd);
            this.$el.html(tmpl({loop: this.loop}));
            return this;
        },
        renderAnswer : function(item){
            var tmpl = _.template(this.templateAnswer);
            this.$el.html(tmpl(item.toJSON()));
            return this;
        },
        yes : function(e){
            e.preventDefault();

            $("#true").html(parseInt($("#true").html()) + 1);
            this.updateStatic("know");
            this.render();
        },
        no : function(e){
            e.preventDefault();

            $("#wrong").html(parseInt($("#true").html()) + 1);
            this.updateStatic("unknow");

            this.renderAnswer(this.orderedItems[this.next-1]);
        },
        continue: function(e){
            e.preventDefault();

            $("#true").html(0);
            $("#wrong").html(0);

            this.next = 0;
            this.render();
        },
        updateStatic : function(result){
            that = this;
            $.ajax({
                url: updateUrl,
                data: {
                    item_id : that.orderedItems[this.next - 1].get("id"),
                    result  : result
                },
                type: "POST",
                complete: function(res){

                }
            });
        }
    });

    quizView = new QuizView();
    $("#start-quiz").click();
});
