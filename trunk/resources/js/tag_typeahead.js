/**
 * Created by felix on 21.02.16.
 */


var tags = new Bloodhound({
    datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    prefetch: {
        url: 'ajax/getTags',
        filter: function(list) {
            return $.map(list, function(tag) { // TODO: tags with spaces are not working ?!
                return { name: tag }; });
        },
        cache: false
    }
});
tags.initialize();

$('.tags_typeahead').tagsinput({
    typeaheadjs: {
        name: 'tags',
        displayKey: 'name',
        valueKey: 'name',
        confirmKeys: [13, 32, 44],
        trimValue: true,
        source: tags.ttAdapter()
    }
});