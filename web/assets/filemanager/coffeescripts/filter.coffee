class window.Filter extends Backbone.View
  searchName: null
  searchType: null
  timeout: null
  className: 'col-md-12'
  events: {
    'input [name="name"]': 'searchByName'
  }
  initialize: () ->
    @render()

  render: () ->
    @$el
      .css {'margin-bottom': '5px'}
      .html document.getElementById('filter-render').innerHTML

  searchByName: () ->
    input = @$el.find '[name="name"]'
    @searchName = input.val().toLowerCase()
    @searchName = null if 3 > @searchName.length
    @searchList()

  searchByType: () ->
    input = @$el.find '[name="type"]'
    @searchType = input.val().toLowerCase()
    @searchType = null if 0 is @searchType.length
    @searchList()

  searchList: () ->
    self = @
    clearTimeout @timeout if @timeout
    @timeout = setTimeout () ->
      list.search self.searchName
    , 500