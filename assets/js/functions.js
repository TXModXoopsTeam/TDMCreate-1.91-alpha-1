function addClick(id) {
    var xhr = getXMLHttpRequest(); // Pour récupérer un objet XMLHTTPRequest
    // -- bordel habituel (readyState == 4, etc, etc.)
    xhr.open('GET', 'click.php?id=' + id, true);
    xhr.send(null);
}

function getXMLHttpRequest() {
    var xhr = null;

    if (window.XMLHttpRequest || window.ActiveXObject) {
        if (window.ActiveXObject) {
            try {
                xhr = new ActiveXObject("Msxml2.XMLHTTP");
            } catch (e) {
                xhr = new ActiveXObject("Microsoft.XMLHTTP");
            }
        } else {
            xhr = new XMLHttpRequest();
        }
    } else {
        alert("Votre navigateur ne supporte pas l'objet XMLHTTPRequest...");
        return null;
    }

    return xhr;
}

function swapImg(swap) {
    obj = document.getElementById(swap);
    obj.src = !(obj.src == img_minus) ? img_minus : img_plus;
}

function showImgSelected2(imgId, selectId, imgDir, extra, xoopsUrl) {
	if (xoopsUrl == null) {
		xoopsUrl = "./";
	}
	imgDom = xoopsGetElementById(imgId);
	selectDom = xoopsGetElementById(selectId);
	if (selectDom.options[selectDom.selectedIndex].value != "") {
		imgDom.src = xoopsUrl + imgDir + "/" + selectDom.options[selectDom.selectedIndex].value + extra;
	} else {
		imgDom.src = xoopsUrl + "/modules/TDMCreate/assets/images/icons/blank.gif";
	}
}

function createNewModuleLogo(xoopsUrl) {  // this is JavaScript  function
	iconDom = xoopsGetElementById(image4);
	iconName = iconDom.src;
	str = xoopsGetElementById(mod_name).value;
	res = str.toLowerCase();
	caption = res.replace(' ', '');
	logoDom = xoopsGetElementById(image3);
	moduleImageDom = xoopsGetElementById(mod_image);
	moduleImageSelected = moduleImageDom.options[moduleImageDom.selectedIndex].value;
	$.ajax({
		type:'GET',
		url:xoopsUrl + "/modules/TDMCreate/class/logoGenerator.php?f=phpFunction&iconName=" + iconName + "&caption=" + caption,
		// call php function , phpFunction=function Name , x= parameter
		data:{},
		dataType:"html",
		success:function (data1) {
			//alert(data1);
			logoDom.src = data1.split('\n')[0];//the data returned has too many lines. We need only the link to the image
			logoDom.load; //refresh the logo
			mycheck=caption+'_logo.png'; //name of the new logo file
			//if file is not in the list of logo files, add it to the dropdown menu
			var fileExist;
			elems = moduleImageDom.options;
			for (var i = 0, max = elems.length; i < max; i++) {
				if (moduleImageDom.options[i].text == mycheck){
					fileExist=true;}
			}
			if (null == fileExist){
				var opt = document.createElement("option");
				document.getElementById("mod_image").options.add(opt);
				opt.text = mycheck;
				opt.value = mycheck;
			}
			$('#mod_image').load;
			$('#mod_image').val(mycheck);//change value of selected logo file to the new file
		}
	});
}

$(document).ready(function() {	
	$('tr.toggleMain td:nth-child(1) img').click(function () {
        $(this).closest('tr.toggleMain').nextUntil('tr.toggleMain').toggle();
    });	
});

function tdmcreate_setStatus( data, img, file ) {
    // Post request
    $.post( file, data , function( reponse, textStatus ) {
        if (textStatus == 'success') {
			$('img#'+img).hide();
			$('#loading_'+img).show();
			setTimeout( function() {
				$('#loading_'+img).hide();
				$('img#'+img).fadeIn('fast');
			}, 500);
            // Change image src
            if ($('img#'+img).attr("src") == IMG_ON) {
                $('img#'+img).attr("src",IMG_OFF);
            } else {
                $('img#'+img).attr("src",IMG_ON);
            }
        }
    });
}