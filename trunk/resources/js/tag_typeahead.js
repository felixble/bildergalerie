/**
 * Created by felix on 21.02.16.
 */


var tags = new Bloodhound({
    datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    prefetch: {
        url: 'ajax/getTags',
        filter: function(list) {
            return $.map(list, function(tag) {
                return { name: tag }; });
        }
    }
});
tags.initialize();

$('.test').tagsinput({
    typeaheadjs: {
        name: 'tags',
        displayKey: 'name',
        valueKey: 'name',
        source: tags.ttAdapter()
    }
});