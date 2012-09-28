<?php
/**
 * Created by JetBrains PhpStorm.
 * User: luckymancvp
 * Date: 9/27/12
 * Time: 1:37 PM
 * To change this template use File | Settings | File Templates.
 *
 * @var $this ItemsController
 * @var $model Items
 * @var $set   Sets
 * @var $form CActiveForm
 */

?>

<script id="blankItem" type="text/template">
    <td class="select-checkbox-td"><?php echo CHtml::checkBox("select-checkbox", true)?></td>
    <td class="input-word-td"><?php echo CHtml::activeTextField($model, "word")?></td>
    <td class="input-meaning-td"><?php echo CHtml::activeTextField($model, "meaning")?></td>
    <td></td>
    <td>
        <div class="btn-toolbar">
            <div class="btn-group">
                <button type="button" class="btn btn-danger del" data-toggle="button">Del</button>
            </div>
            <div class="btn-group">
                <button type="button" class="btn btn-info trans" data-toggle="button">Trans</button>
                <button type="button" class="btn btn-success save" data-toggle="button">Save</button>
            </div>
        </div>
    </td>
</script>

<div id="multi" class="tab-pane">

    <!-- Grid row -->
    <div class="row">

        <article class="span12">
            <div class="row">
                <div class="span6">
                    <h3>Multi Items</h3>
                </div>
            </div>

            <table class="datatable table table-striped table-bordered" id="table-items">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Word</th>
                    <th>Meaning</th>
                    <th>Sound</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>

            <div class="row">
                <div class="span3">
                    <div class="btn-group btn-mini">
                        <a id="add-more" class="btn btn-inverse dropdown-toggle" data-toggle="dropdown" href="#">Add More <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <?php
                            echo CHtml::tag("li",array(), CHtml::link("+5","#add-more",array(
                                "onClick"=>new CJavaScriptExpression("masterView.addBlank(5)"),
                            )));
                            echo CHtml::tag("li",array(), CHtml::link("+10","#add-more",array(
                                "onClick"=>new CJavaScriptExpression("masterView.addBlank(10)"),
                            )));
                            echo CHtml::tag("li",array(), CHtml::link("+15","#add-more",array(
                                "onClick"=>new CJavaScriptExpression("masterView.addBlank(15)"),
                            )));
                            ?>
                            <li class="divider"></li>
                            <li><a href="#">Custom</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </article>
        <!-- /Page grid cell (12 blocks - full) -->

    </div>
    <!-- /Grid row -->
</div>



<!-- jQuery DataTable -->
<?php
    Yii::app()->clientScript->registerScriptFile(Html::jsThemeUrl("plugins/dataTables/jquery.datatables.min.js"));
    Yii::app()->clientScript->registerScriptFile(Html::jsThemeUrl("items/multi.js"));
?>
		<script>
            /* Default class modification */
            $.extend( $.fn.dataTableExt.oStdClasses, {
                "sWrapper": "dataTables_wrapper form-inline"
            } );

            /* API method to get paging information */
            $.fn.dataTableExt.oApi.fnPagingInfo = function ( oSettings )
            {
                return {
                    "iStart":         oSettings._iDisplayStart,
                    "iEnd":           oSettings.fnDisplayEnd(),
                    "iLength":        oSettings._iDisplayLength,
                    "iTotal":         oSettings.fnRecordsTotal(),
                    "iFilteredTotal": oSettings.fnRecordsDisplay(),
                    "iPage":          Math.ceil( oSettings._iDisplayStart / oSettings._iDisplayLength ),
                    "iTotalPages":    Math.ceil( oSettings.fnRecordsDisplay() / oSettings._iDisplayLength )
                };
            }

            /* Bootstrap style pagination control */
            $.extend( $.fn.dataTableExt.oPagination, {
                "bootstrap": {
                    "fnInit": function( oSettings, nPaging, fnDraw ) {
                        var oLang = oSettings.oLanguage.oPaginate;
                        var fnClickHandler = function ( e ) {
                            e.preventDefault();
                            if ( oSettings.oApi._fnPageChange(oSettings, e.data.action) ) {
                                fnDraw( oSettings );
                            }
                        };

                        $(nPaging).addClass('pagination').append(
                                '<ul>'+
                                        '<li class="prev disabled"><a href="#">&larr; '+oLang.sPrevious+'</a></li>'+
                                        '<li class="next disabled"><a href="#">'+oLang.sNext+' &rarr; </a></li>'+
                                        '</ul>'
                        );
                        var els = $('a', nPaging);
                        $(els[0]).bind( 'click.DT', { action: "previous" }, fnClickHandler );
                        $(els[1]).bind( 'click.DT', { action: "next" }, fnClickHandler );
                    },

                    "fnUpdate": function ( oSettings, fnDraw ) {
                        var iListLength = 5;
                        var oPaging = oSettings.oInstance.fnPagingInfo();
                        var an = oSettings.aanFeatures.p;
                        var i, j, sClass, iStart, iEnd, iHalf=Math.floor(iListLength/2);

                        if ( oPaging.iTotalPages < iListLength) {
                            iStart = 1;
                            iEnd = oPaging.iTotalPages;
                        }
                        else if ( oPaging.iPage <= iHalf ) {
                            iStart = 1;
                            iEnd = iListLength;
                        } else if ( oPaging.iPage >= (oPaging.iTotalPages-iHalf) ) {
                            iStart = oPaging.iTotalPages - iListLength + 1;
                            iEnd = oPaging.iTotalPages;
                        } else {
                            iStart = oPaging.iPage - iHalf + 1;
                            iEnd = iStart + iListLength - 1;
                        }

                        for ( i=0, iLen=an.length ; i<iLen ; i++ ) {
                            // Remove the middle elements
                            $('li:gt(0)', an[i]).filter(':not(:last)').remove();

                            // Add the new list items and their event handlers
                            for ( j=iStart ; j<=iEnd ; j++ ) {
                                sClass = (j==oPaging.iPage+1) ? 'class="active"' : '';
                                $('<li '+sClass+'><a href="#">'+j+'</a></li>')
                                        .insertBefore( $('li:last', an[i])[0] )
                                        .bind('click', function (e) {
                                            e.preventDefault();
                                            oSettings._iDisplayStart = (parseInt($('a', this).text(),10)-1) * oPaging.iLength;
                                            fnDraw( oSettings );
                                        } );
                            }

                            // Add / remove disabled classes from the static elements
                            if ( oPaging.iPage === 0 ) {
                                $('li:first', an[i]).addClass('disabled');
                            } else {
                                $('li:first', an[i]).removeClass('disabled');
                            }

                            if ( oPaging.iPage === oPaging.iTotalPages-1 || oPaging.iTotalPages === 0 ) {
                                $('li:last', an[i]).addClass('disabled');
                            } else {
                                $('li:last', an[i]).removeClass('disabled');
                            }
                        }
                    }
                }
            });
        </script>