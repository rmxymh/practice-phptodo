@extends('layouts.base')

@section('title')
{{ $title }}
@endsection

@section('scripts')
<script src="javascripts/todo.js"></script>
@endsection

@section('body')
<div class="row">
<div class="col-sm-12 jumbotron bg-primary">
	<h2>Add Todo Item</h2>
	<form class="form-inline" accept-charset="utf-8">
		<div class="row">
			<div class="form-group col-sm-10">
				<div class="row">
					<div class="input-group col-sm-10">
						<label class="sr-only" for="todoContent">Todo Item</label>
						<input id="todoContent" class="form-control" type="text" name="todoContent" placeholder="Todo Item..."/>
					</div>
				</div>
				<div class="row" style="padding-top: 10px;">
					<div class="input-group col-sm-10">
						<label class="sr-only" for="todoComment">Todo Comment</label>
						<textarea id="todoComment" class="form-control" type="text" name="todoComment" rows="4" cols="40" placeholder="Todo Comment..."></textarea>
					</div>
				</div>
			</div>
			<div class="col-sm-2">
				<button id="addTodoBtn" class="btn btn-primary">Add</button>
			</div>
		</div>
	</form>
</div>
</div>

@foreach ($todos as $todo)

<div class="alert alert-info">
	<div class="row">
		<div class="col-sm-10">
				<span class="glyphicon glyphicon-tag" style="padding-right: 10px;"></span>{{ $todo->content }}
		</div>
		<div class="col-sm-2">
			<button class="btn btn-warning btn-sm" todo-act="edit" todo-id="{{ $todo->id }}" todo-content="{{ $todo->content }}" todo-comment="{{ $todo->comment }}">Edit</button>
			<button class="btn btn-danger btn-sm" todo-act="delete" todo-id="{{ $todo->id }}">Delete</button>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-10">
			@if ( strlen($todo->comment) > 0)
			<pre>{{ $todo->comment }}</pre>
			@endif
		</div>
	</div>
</div>
@endforeach

<!-- modal -->
<div class="modal fade" id="modifyTodoItemModal" tabindex="-1" role="dialog" aria-labelledby="modifyTodoItemLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="modifyTodoItemLabel">Modify Todo Item</h4>
			</div>
			<div class="modal-body">
				<input id="modTodoContent" class="form-control" type="text" placeholder="Todo Item..."/>
				<textarea id="modTodoComment" class="form-control" row="4" column="32" placeholder="Todo Comment..."></textarea>
				<input id="modTodoItemId" type="hidden" value=""/>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button id="modifyTodoBtn" type="button" class="btn btn-warning">Modify</button>
			</div>
		</div>
	</div>
</div>

<script>
	$(document).ready(function() {
		$('#addTodoBtn').click(function() {
			createTodoItem('{{ $username }}');
		});
		$('button[todo-act="delete"]').each(function(index) {
			$(this).click(function() {
				deleteTodoItem($(this).attr("todo-id"), '{{ $username }}');
			});
		});
		$('button[todo-act="edit"]').each(function(index) {
			$(this).click(function() {
				console.log("edit todo item " + $(this).attr("todo-id"));
				$("#modTodoContent").val($(this).attr("todo-content"));
				$("#modTodoComment").val($(this).attr("todo-comment"));
				$("#modTodoItemId").val($(this).attr("todo-id"));
				$("#modifyTodoItemModal").modal("toggle");
			});
		});
		$("#modifyTodoBtn").click(function() {
			modifyTodoItem('{{ $username }}');
		});
	});
</script>
@endsection
