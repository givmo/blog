(function($){
    var SimpleSocialBarAdmin = function(){
        var elems = {};
        var ns = __namespace;
        
        function assignEvents(){
            elems.buttonList.sortable({
                handle: '.handle',
                axis: 'y',
                items: 'li.button-row',
                update: function(event, ui){
                    elems.buttonList.find('.button-order').each(function(ind){
                        this.value = ind + 1;
                    });
                }
            });
            
            elems.editButtons.bind('click.' + ns, function(event){
                event.preventDefault();
                
                editCode(this);
            });
        }
        
        function editCode(el){
            var $el = $(el);
            $el.closest('.button-row').find('.button-codesnippet').slideToggle();
        }
        
        function initialize(){
            elems.buttonList = $('#button-list');
            elems.editButtons = elems.buttonList.find('.button-edit');
            
            assignEvents();
        }
        
        initialize();
    };
    
    $(document).ready(function(){
        new SimpleSocialBarAdmin();
    });
})(jQuery);
