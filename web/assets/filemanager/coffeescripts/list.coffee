class window.List extends Backbone.View
  tagName: 'table'
  className: 'table table-condensed table-hover table-bordered table-list'
  initialize: () ->
    @collection = new (Backbone.Collection.extend {model: Backbone.Model})()
    @collection.on 'add', @addModel, @
    @collection.on 'remove', @removeModel, @
    @render()

  render: () ->
    @$el.prepend document.getElementById('list-header').innerHTML
    @$el.css 'background-color', 'white'

  setItems: (items) ->
    @collection.set items

  addModel: (model) ->
    view = new ListItem {
      model: model
    }
    model.view = view
    @$el.append view.$el

  removeModel: (model) ->
    model.view.remove() if model.view

  loadList: () ->
    self = @
    $.ajax {
      url: '/files'
      type: 'GET'
      dataType: 'json'
      success: (list) ->
        if list
          self.setItems list
          return
        throw new Error 'Не удалось получить список'

      error: (e) ->
        throw new Error 'Не удалось получить список', e.getMessage()
    }

  search: (search) ->
    for model in @collection.models
      model.view.$el.show()
    self = @
    if search
      $.ajax {
        url: '/search'
        type: 'GET'
        data: {
          search: search
        }
        dataType: 'json'
        success: (ids) ->
          for model in self.collection.models
            model.view.$el.hide() if -1 == ids.indexOf(model.get('id'))

        error: (e) ->
          throw new Error 'Не удалось отобразить файл', e.getMessage()
      }

class window.ListItem extends Backbone.View
  template: _.template document.getElementById('list-item').innerHTML
  tagName: 'tr'
  events: {
    'click': 'show'
    'click .btndelete': 'delete'
  }
  initialize: () ->
    @render()

  render: () ->
    @$el.html @template {
      name: @model.get 'name'
      type: @model.get 'type'
    }

  show: (e) ->
    return if $(e.target).hasClass('btndelete')
    $.ajax {
      url: '/file'
      type: 'GET'
      data: {
        id: @model.get('id')
      }
      dataType: 'html'
      success: (form) ->
        if form
          $ '#right-content'
            .html form
          $ '#right-content img'
            .on 'contextmenu', (e) ->
              e.preventDefault()
          return
        throw new Error 'Не удалось отобразить файл'

      error: (e) ->
        throw new Error 'Не удалось отобразить файл', e.getMessage()
    }

  delete: (e) ->
    btn = $(e.target).closest('.btndelete')
    self = @
    if 'Удалить' == btn.html()
      btn.html 'Вы уверены?'
      setTimeout () ->
        btn.html 'Удалить'
      , 2000
    else
      $.ajax {
        url: '/file'
        type: 'DELETE'
        data: {
          id: @model.get('id')
        }
        dataType: 'json'
        success: (res) ->
          self.remove() if res
        error: (e) ->
          throw new Error 'Не удалось удалить файл', e.getMessage()
      }