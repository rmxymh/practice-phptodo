/*
 * Dependency: 
 * 1. jQuery.js
 */

// Utility: from http://stackoverflow.com/questions/901115/how-can-i-get-query-string-values-in-javascript
function getParameterByName(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}


var Todo = {}

Todo.create = function(content, comment, session) {
	$.ajax({
		type: "POST",
		url: "/api/todo?user=" + session,
		data: {
			content: content,
			comment: comment,
			user: session,
		},
		success: function(data) {
			window.location.replace("todo");
		},
		error: function(data) {
			alert("Failed to add a new todo item.");
			window.location.replace("todo");
		}
	});
}

Todo.modify = function(id, content, comment, session) {
	$.ajax({
		type: "PUT",
		url: "/api/todo/" + id + "?user=" + session,
		data: {
			content: content,
			comment: comment
		},
		success: function(data) {
			window.location.replace("todo?user=" + session);
		},
		error: function(data) {
			alert("Failed to add a new todo item.");
			window.location.replace("todo?user=" + session);
		}
	});
}

Todo.delete = function(id, session) {
	$.ajax({
		type: "DELETE",
		url: "/api/todo/" + id + "?user=" + session,
		success: function(data) {
			window.location.replace("todo?user=" + session);
		},
		error: function(data) {
			alert("Failed to remove a new todo item.");
			window.location.replace("todo?user=" + session);
		}
	});
}


function createTodoItem(session) {
	var content = $("#todoContent").val();
	var comment = $("#todoComment").val();

	Todo.create(content, comment, session);
}

function deleteTodoItem(id, session) {
	Todo.delete(id, session);
}

function modifyTodoItem(session) {
	var content = $("#modTodoContent").val();
	var comment = $("#modTodoComment").val();
	var id = $("#modTodoItemId").val();

	Todo.modify(id, content, comment, session);
}

