$(document)
	.ready(function() 
	{
		var iPage = 1;
		
		function fnGetFormData() 
		{
			var oResult = {};
			$("#filter-form input").each(function(iKey, oObject) 
			{
				oResult[$(oObject).attr("name")] = $(oObject).val();
			});
			return oResult;
		}

		function fnSendFormData(bAppend = false) 
		{
			$.post(
					`/?page=${iPage}`, 
					fnGetFormData()
				)
				.done(function(oData) 
				{
					if (bAppend)
						$(".objects-list").append(oData);
					else
						$(".objects-list").html(oData);
				});
		}
		
		function fnSaveFormData() 
		{
			var oData = fnGetFormData();
			
			for(var sKey in oData) {
				$.cookie(sKey, oData[sKey]);
				//console.log($.cookie(sKey));
			}
		}
		
		function fnLoadFormData() 
		{
			$("#filter-form input").each(function(iKey, oObject) 
			{
				if ($.cookie($(oObject).attr("name")))
					$(oObject).val($.cookie($(oObject).attr("name")));
			});			
		}
		
		$(".filter-form__submit")
			.click(function() 
			{
				iPage = 1;
				fnSendFormData();
				return false;
			});
		
		$(window)
			.scroll(function() 
			{
				if (document.documentElement.offsetHeight + document.documentElement.scrollTop == document.documentElement.scrollHeight) {
					if (iPage >= iNumberOfPages)
						return;
		
					iPage++;
					fnSendFormData(true);
				}
			});

		fnLoadFormData();
				
		$('.range-selector')
			.each(function(iIndex, oElement) 
			{
				var $oElement = $(oElement);
				var iElementSliderWidth;
				var iSliderButtonWidth;
				var $oElementSlider;
				var $oActiveLine;
				var $oSliderButton1;
				var $oSliderButton2;
				var iMax = $oElement.data('max');
				var iMin = $oElement.data('min');
				var iDelta = iMax-iMin;
				var $oRangeSelectorMax = $oElement.find('.range-selector__max');
				var $oRangeSelectorMin = $oElement.find('.range-selector__min');
				var iPositionMax = $oRangeSelectorMax.val();
				var iPositionMin = $oRangeSelectorMin.val();
				var bSliderButton1MouseDown = false;
				var bSliderButton2MouseDown = false;

				function fnUpdateSlider() 
				{
					iPositionMin = $oRangeSelectorMin.val()*1;
					
					if (iPositionMin<=iMax && iPositionMin<iPositionMax && iPositionMin>=iMin)
						$oSliderButton1.css("left", Math.round((iPositionMin-iMin)*iElementSliderWidth/iDelta)+"px");

					iPositionMax = $oRangeSelectorMax.val()*1;

					if (iPositionMax<=iMax && iPositionMin<iPositionMax && iPositionMax>=iMin)
						$oSliderButton2.css("left", Math.round((iPositionMax-iMin)*iElementSliderWidth/iDelta)+"px");
					
					fnUpdateActiveLine();
				}
				
				function fnUpdateSliderInput()
				{
					$oRangeSelectorMin.val(Math.round(parseFloat($oSliderButton1.css("left"))*iDelta/iElementSliderWidth+iMin));
					$oRangeSelectorMax.val(Math.round(parseFloat($oSliderButton2.css("left"))*iDelta/iElementSliderWidth+iMin));

					if ($oElement.hasClass("floor-selector")) {
						var iRangeSelectorMin = $oElement.find(".range-selector__min").val();
						var iRangeSelectorMax = $oElement.find(".range-selector__max").val();
						
						$(".filter-form__block-label-2").text(`от ${iRangeSelectorMin} до ${iRangeSelectorMax}`);
					}
					
					fnUpdateActiveLine();
					fnSaveFormData();
				}
				
				function fnUpdateActiveLine() 
				{
					$oActiveLine.css("left", $oSliderButton1.css("left"));
					$oActiveLine.css("width", parseInt($oSliderButton2.css("left"))-parseInt($oSliderButton1.css("left")));
				}
				
				$oElement.append(`
					<div class="slider col-md-11">
						<div class="slider-line"></div>
						<div class="slider-active-line"></div>
						<div class="slider-button-1"></div>
						<div class="slider-button-2"></div>
					</div>
				`);
				$oSliderButton1 = $oElement.find(".slider-button-1");
				$oSliderButton2 = $oElement.find(".slider-button-2");
				$oActiveLine = $oElement.find(".slider-active-line");
				$oElementSlider = $oElement.find('.slider');
				iSliderButtonWidth = $oSliderButton1.width();
				iElementSliderWidth = $oElementSlider.width() - iSliderButtonWidth;
				
				$oSliderButton1.mousedown(function(oEvent) 
				{
					bSliderButton1MouseDown = true;
				});

				$oSliderButton2.mousedown(function(oEvent) 
				{
					bSliderButton2MouseDown = true;
				});
				
				$(window).mousemove(function(oEvent) 
				{
					if (!bSliderButton1MouseDown && !bSliderButton2MouseDown)
						return;
					if (bSliderButton1MouseDown) {
						if (oEvent.clientX>$oSliderButton2.offset().left)
							return;
						if (oEvent.clientX<$oElementSlider.offset().left) {
							$oSliderButton1.css("left", "0px");
						} else if (oEvent.clientX>$oElementSlider.offset().left+iElementSliderWidth) {
							$oSliderButton1.css("left", iElementSliderWidth+"px");
						} else {
							$oSliderButton1.css("left", (oEvent.clientX-$oElementSlider.offset().left)+"px");
						}
					}
					if (bSliderButton2MouseDown) {
						if (oEvent.clientX<$oSliderButton1.offset().left)
							return;
						if (oEvent.clientX<$oElementSlider.offset().left) {
							$oSliderButton2.css("left", "0px");
						} else if (oEvent.clientX>$oElementSlider.offset().left+iElementSliderWidth) {
							$oSliderButton2.css("left", iElementSliderWidth+"px");
						} else {
							$oSliderButton2.css("left", (oEvent.clientX-$oElementSlider.offset().left)+"px");
						}
					}
					fnUpdateSliderInput();
				});

				$(window).mouseup(function() 
				{
					bSliderButton1MouseDown = false;
					bSliderButton2MouseDown = false;
				});
				
				$oElement.find(".range-selector__min, .range-selector__max").change(function()
				{
					fnUpdateSlider();
				});
				
				fnUpdateSlider();
			});
		
		fnSendFormData();
	});