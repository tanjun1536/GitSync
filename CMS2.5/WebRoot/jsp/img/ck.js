window.ck = {};
window.ck.h = function(){
	var finder = new CKFinder();
	finder.BasePath = 'http://localhost:8080/CMS/javascript/ckfinder';
	finder.SelectFunction = SetFileField;
	finder.Skin = 'v1';
	finder.Popup();
};
window.ck.h.SetFileField =
function SetFileField( fileUrl )
{
	alert(fileUrl);
};