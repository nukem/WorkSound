function propergate_agent_data(){
	// Save the name of the XML file, including the agent's id.
	var agentXML = $('#xml-feed').val();
	var agentID = $('#selectagent:selected').val();
	var xmlFeed = agentXML + agentID;
	// Open the XML file.
	$.get(xmlFeed, {}, function(agent) {
		$('Member', agent).each(function(i) {
			// Save the values found in the XML file as variables.
			var firstname = $(this).find('FirstName').text();
			var surname = $(this).find('Surname').text();
			var position = $(this).find('Position').text();
			var mobile = $(this).find('Mobile').text();
			var email = $(this).find('Email').text();
			var telelphone = $(this).find('Telephone').text();
			var about = $(this).find('About').text();
		});
	});
	// Now that we have the variables, set the input boxes.
	$('title').val(firstname + ' ' + surname);
	$('#position').val(position);
	$('#mobile').val(mobile);
	$('#email').val(email);
	$('#telephone').val(telephone);
	$('#about').val(about);
}
