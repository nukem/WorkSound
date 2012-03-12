	/*
		Picpreview.js 
		Version 1.1
		written by Christian Heilmann 
		Homepage: http://www.icant.co.uk/articles/picpreview/
		Licensed Creative Commons 2.5	
		http://creativecommons.org/licenses/by/2.5/		
	*/
	function picpreview()
	{
		// is PHP available? true of false
		var hasphp=true;
		// options for the url depending on the PHP availability
		var hasphpurl='thumb.php?i=';
		var thumb='tn_';
		// class to identify links to be enhanced
		var previewclass='preview';
		// link added to the newly created preview links
		var previewlinkclass='previewlink';
		// class added to the preview image
		var previewimageclass='previewimage';
		// image to show next to each preview link + alternative
		var previewimage='camera.gif';
		var previewalternative='see a preview of this image';
		// image to show while the thumb is loaded + alternative
		var loadingimage='loading.gif';
		var loadingalternative='Loading...';

				
		// Loop over all links
		var links=document.getElementsByTagName('a');

		// Define "caching" array, as we will alter th links array
		var prevlinks=new Array();
		var c=0;
	
		// Define test pattern 	
		var previewTest = new RegExp("(^|\\s)" + previewclass + "(\\s|$)");

		// Loop over all links and filter out links without the necessary class
		for(var i=0;i<links.length;i++)
		{
			if(!previewTest.test(links[i].className)){continue;}
			prevlinks[c]=links[i];			
			c++;
		}
		
		// Loop over all links with the preview class
		for(var i=0;i<prevlinks.length;i++)
		{
		//  create new link, preview image and set the correct attributes		
	
			var newa=document.createElement('a');
			newa.className=previewlinkclass;
			var newimg=document.createElement('img');
			newimg.src=previewimage;
			newimg.alt=previewalternative;
			newimg.className=previewimageclass;
			newa.appendChild(newimg);
			newa.href="#";
		// add function when the preview link is  activated
			newa.onclick=function()
			{
		// If there is already a second image, remove it
				if(this.getElementsByTagName('img')[1])
				{
					this.removeChild(this.getElementsByTagName('img')[1]);

		// Otherwise create a new image and set the "loading" message attributes
				} else {
					var newimg=document.createElement('img');
					newimg.src=loadingimage;
					newimg.alt=loadingalternative;
					this.appendChild(newimg);
	
		// Create a new image and set its URL to thumb of the linked image 
		// depending on hasphp, this is a file url or one pointing to the php script	
		// Add a random value to prevent caching issues
					var newimg=document.createElement('img');
					this.appendChild(newimg);
					var rand=parseInt(777*Math.random(0,1));
				newimg.src=hasphp?geturl(this.previousSibling.href)+"&r="+rand:geturl(this.previousSibling.href);
		// If the image has successfully loaded, remove the loading image 
					newimg.onload=function()
					{
						this.parentNode.removeChild(this.parentNode.getElementsByTagName('img')[1]);
					}
				}
		//  don't follow the initial link
				return false;
			}

		//  add preview link after the real one
			prevlinks[i].parentNode.insertBefore(newa,prevlinks[i].nextSibling);
			newa=null;
			newimg=null;
		}

		// Tool method to create the URL to  the thumb
		function geturl(url)
		{
			url=url.split('/');
			url=hasphp?hasphpurl+url[url.length-1]:thumb+url[url.length-1];
			return url;
		}
	}	

// When the window has loaded, test for DOM and execute script
	window.onload=function()
	{
		if(!document.getElementById || !document.createTextNode){return;}
		picpreview()
	}
