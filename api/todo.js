 $(document).ready(function() {
	// Stuff
	fetch_items();

	$('#form').submit(function(event) {
		$.ajax({
			url: 'includes/base.php',
			type: 'POST',
			timeout: 5000,
			data: {
				"add-item": $('#add-item').val()
			}
		}).done(function() {
			fetch_items();
			$('#add-item').val('');
		}).fail(function() {
			alert('Cant submit tasks');
		});
		return false; // Hindrar webbläsaren från att göra en submit
	});
});

function fetch_items() {
	// Ajax-anrop
	$.ajax({
		url: 'includes/base.php',
		type: 'GET',
		timeout: 5000
	}).done(function(data) {
		$('#items').empty(); // Tömma listan innan ny data hämtas från tabellen
		for (var i = 0; i < data.task.length; i++) {
			var span = $('<span>').append('✖').data('taskId', data.task[i].id).click(function() {
				delete_task($(this).data('taskId'));
			});
			var listItem = $('<li>').text(data.task[i].task);
			listItem.append(span);
			$('#items').append(listItem);
		}
	}).fail(function() {
		alert('Could no fetch tasks');
	});
}

function delete_task(id) {
	$.ajax({
		url: 'includes/base.php',
		type: 'DELETE',
		timeout: 5000,
		data: {
			id: id
		}
	});
	fetch_items();
}

function batman() {
	var bat = array(5).join("wat" -1) + " Batman!";
	return bat;
}


// http://stackoverflow.com/questions/19909533/disable-rubber-band-in-ios-full-screen-web-app