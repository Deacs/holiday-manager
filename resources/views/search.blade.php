@extends('master')

<style>
    .algolia-autocomplete {
        width: 100%;
    }
    .algolia-autocomplete .aa-input, .algolia-autocomplete .aa-hint {
        width: 100%;
    }
    .algolia-autocomplete .aa-hint {
        color: #999;
    }
    .algolia-autocomplete .aa-dropdown-menu {
        width: 100%;
        background-color: #fff;
        border: 1px solid #999;
        border-top: none;
    }
    .algolia-autocomplete .aa-dropdown-menu .aa-suggestion {
        cursor: pointer;
        padding: 5px 4px;
    }
    .algolia-autocomplete .aa-dropdown-menu .aa-suggestion.aa-cursor {
        background-color: #B2D7FF;
    }
    .algolia-autocomplete .aa-dropdown-menu .aa-suggestion em {
        font-weight: bold;
        font-style: normal;
        background: #7be500;
    }
    .algolia-autocomplete .category {
        text-align: left;
        background: #F08E01;
        color: #ffffff;
        padding: 10px 5px;
        font-weight: bold;
    }
    .pitch {
        border-top: 1px solid #eeeeee;
    }
    .title {
        color: #F08E01;
        font-size: larger;
        font-weight:bold;
        padding-top: 15px;
    }
    .title a {
        color: #F08E01;
    }
    .description {
        font-size: smaller;
    }
    .raised {
        color: #64A816;
        font-weight: bold;
    }
</style>

@section('content')
    <div class="row">
        <h4>Search Crowdcube</h4>
    </div>

    <div class="row">
        <input type="text" id="search-input" placeholder="Try something" />
    </div>

@endsection

@section('scripts')
    <script src="//cdn.jsdelivr.net/algoliasearch/3/algoliasearch.min.js"></script>
    <script src="//cdn.jsdelivr.net/hogan.js/3.0/hogan.min.js"></script>
    <script src="//cdn.jsdelivr.net/autocomplete.js/0/autocomplete.min.js"></script>
    <script>
        var client = algoliasearch("WPJE7ZD8RV", "e0a7331b6f7141e375e25b70f7407b46");
        var pitches = client.initIndex('cc_dev_pitches');
        // Mustache templating by Hogan.js (http://mustache.github.io/)
        var templatePitch = Hogan.compile('<div class="pitch">' +
                '<div class="row">'+
                '<div class="logo large-1 columns"<a href="@{{ url }}"><img src="@{{ thumb_path }}" width="100px" alt="@{{ title }} Logo"></a></div>'+
                '<div class="title large-11 columns"><a href="@{{ url }}">@{{{ _highlightResult.title.value }}}</a></div>'+
                '</div>'+
                '<div class="request">Amount Raised: <span class="raised">£@{{ amount_raised }}</span> (@{{ progress }}%) from <span class="raised">@{{ investors }} investors</span></div>' +
                '<div class="description">@{{{ _highlightResult.description.value }}}</div>' +
                '</div>');

        var content = client.initIndex('cc_dev_content');
        var templateContent = Hogan.compile('<div class="content">' +
                '<div class="title">@{{{ _highlightResult.title.value }}}</div>' +
                '<div class="description">@{{{ _highlightResult.site_description.value }}}</div>' +
                '</div>');

        // autocomplete.js initialization
        autocomplete('#search-input', {hint: false}, [
            {
                source: autocomplete.sources.hits(pitches, {hitsPerPage: 10}),
                displayKey: 'name',
                templates: {
                    header: '<div class="category">Pitches</div>',
                    suggestion: function(hit) {
                        // render the hit using Hogan.js
                        return templatePitch.render(hit);
                    }
                }
            },
            {
                source: autocomplete.sources.hits(content, {hitsPerPage: 5}),
                displayKey: 'name',
                templates: {
                    header: '<div class="category">Content</div>',
                    suggestion: function(hit) {
                        // render the hit using Hogan.js
                        return templateContent.render(hit);
                    }
                }
            }

        ]).on('autocomplete:selected', function(event, suggestion, dataset) {
            console.log(suggestion, dataset);
        });

//        autocomplete('#search-input', {hint: false}, [
//            {
//                source: autocomplete.sources.hits(index, {hitsPerPage: 5}),
//                displayKey: 'title',
//                templates: {
//                    suggestion: function(suggestion) {
//                        return suggestion._highlightResult.title.value;
//                    }
//                }
//            }
//        ]).on('autocomplete:selected', function(event, suggestion, dataset) {
//            console.log(suggestion, dataset);
//            console.log('Open Pitch Page');
//        });
    </script>
@endsection
