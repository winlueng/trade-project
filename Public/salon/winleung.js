

function ajax_get(string) {
	var data = string;
	var result;
	result = $.get(url,data,function info(res){
		return  res;
	});
	return result;
}