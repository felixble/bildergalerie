/**
 * Created by felix on 21.02.16.
 */


var citynames = new Bloodhound({
    datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    prefetch: {
        url: 'ajax/getTags',
        filter: function(list) {
            return $.map(list, function(cityname) {
                return { name: cityname }; });
        }
    }
});
citynames.initialize();

$('.test').tagsinput({
    typeaheadjs: {
        name: 'citynames',
        displayKey: 'name',
        valueKey: 'name',
        source: citynames.ttAdapter()
    }
});