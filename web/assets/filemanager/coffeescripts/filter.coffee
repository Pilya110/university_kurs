class window.Filter extends Backbone.View
  searchName: null
  searchType: null
  timeout: null
  className: 'col-md-12'
  events: {
    'input [name="name1"]': 'searchByName'
    'click .srchbtn': 'searchOiler'
  }
  initialize: () ->
    @render()

  render: () ->
    @$el
      .css {'margin-bottom': '5px'}
      .html document.getElementById('filter-render').innerHTML

  searchByName: () ->
    input = @$el.find '[name="name1"]'
    @searchName = input.val().toLowerCase()
    @searchName = null if 3 > @searchName.length
    @searchList()

  searchList: () ->
    self = @
    clearTimeout @timeout if @timeout
    @timeout = setTimeout () ->
      list.search self.searchName
    , 500

  searchOiler: () ->
    elems = @$el.find '[data-type="oil"]'
    data = {}
    cnt = 0
    for el in elems
      name = $(el).attr 'name'
      val = $(el).val()
      if 'string' == typeof val && '' != val
        cnt++
        data[name] = val
    if 0 < cnt
      list.search data