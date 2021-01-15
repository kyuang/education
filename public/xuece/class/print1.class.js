<script>
(function($) {
    var printAreaCount = 0;
    $.fn.printArea = function(){
        var ele = $(this);
        var idPrefix = "printArea_";
        removePrintArea( idPrefix + printAreaCount );
        printAreaCount++;
        var iframeId = idPrefix + printAreaCount;
        var iframeStyle = 'position:absolute;width:0px;height:0px;left:-500px;top:-500px;';
        iframe = document.createElement('IFRAME');
        $(iframe).attr({ style : iframeStyle,id : iframeId});
        document.body.appendChild(iframe);
        var doc = iframe.contentWindow.document;
// alert(doc)
// doc.open();
        $(document).find("link")
            .filter(function(){
                return $(this).attr("rel").toLowerCase() == "stylesheet";
            })
            .each(function(){
                doc.open();
                doc.write('<link type="text/css" rel="stylesheet" href="' +
                    $(this).attr("href") + '" >');
// alert($(this).attr("href"))
            });
        doc.write('<div class="' + $(ele).attr("class") + '">' + $(ele).html() + '</div>');
        doc.close();
        var frameWindow = iframe.contentWindow;
// alert(frameWindow)
        frameWindow.close();
        frameWindow.focus();
        frameWindow.print();
        frameWindow.focus();
    }
    var removePrintArea = function(id){
        $( "iframe#" + id ).remove();
    };
})(jQuery);
</script>

