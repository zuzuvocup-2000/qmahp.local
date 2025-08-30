$(document).ready(function(){

	if($('.detail-member').length){
		$('.detail-member').each(function(){
			let _this = $(this);
			let type = _this.attr('data-select')
			let data = _this.attr('data-variable')
			let module = _this.attr('data-module');
			console.log(data)
			if(data != 'IiI='){
				setTimeout(function(){
				if(data != ''){
					$.post('ajax/dashboard/pre_select2_dangvien', {
						value: data, module: module, type: type},
						function(data){
							let json = JSON.parse(data);
							if(json.items!='undefined' && json.items.length){
								for(let i = 0; i< json.items.length; i++){
									var option = new Option(json.items[i].text, json.items[i].id, true, true);
									_this.append(option).trigger('change');
								}
							}
						});
				}
			}, 10);
			}

			select2_dangvien(_this);
		})
	}
})

function select2_dangvien(object){
	let type = object.attr('data-select')
	let module = object.attr('data-module');
	object.select2({
		minimumInputLength: 2,
		maximumSelectionLength: 5,
		placeholder: 'Nhập 2 từ khóa để tìm kiếm...',
		ajax: {
			url: 'ajax/dashboard/dangvien_select2',
			type: 'POST',
			dataType: 'json',
			deley: 250,
			data: function (params) {
				return {
					locationVal: params.term,
					module: module,
					type: type,

				};
			},
			processResults: function (data) {
				return {
					results: $.map(data, function(obj, i){
						return obj
					})
				}
				
			},
			cache: true,
		}
	});
}