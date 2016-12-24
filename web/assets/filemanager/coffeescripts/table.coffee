class window.Table extends Backbone.View
  tagName: 'table'
  className: 'table table-condensed table-hover table-bordered'
  initialize: (data) ->
    @fields = data.fields
    @table = data.table
    @$el.css {
      'background-color': 'white'
    }
    @render()

  render: () ->
    tr = $('<tr></tr>')
    for f of @fields
      tr.append('<th>'+@fields[f]+'</th>')
    @$el.append tr
    self = @
    $.ajax {
      url: '/table'
      type: 'GET'
      data: {
        table: @table
      }
      dataType: 'json'
      success: (list) ->
        if list
          self.setItems list
          return
        throw new Error 'Не удалось получить список'

      error: (e) ->
        throw new Error 'Не удалось получить список', e.getMessage()
    }

  setItems: (list) ->
    for item in list
      @$el.append((new TableTr({
        item: item
        fields: @fields
        table: @table
      })).$el)



class window.TableTr extends Backbone.View
  tagName: 'tr'
  initialize: (@data) ->
    @render()

  render: () ->
    for field of @data.fields
      console.log field, @data.item[field]
      @$el.append('<td>'+@data.item[field]+'</td>')
