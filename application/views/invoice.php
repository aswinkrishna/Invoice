<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Invoice</title>

<!-- Style Sheet -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<!-- Font Awzome -->
<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">

<!-- Custom CSS -->
<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/custom.css">

<!-- JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="<?=base_url()?>assets/js/validation.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/fontawesome.min.js"></script>

</head>
<body>

<div class="container">
  	<div class="row">

  		<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 padding">
  			<button class="btn btn-primary" id="print_invoice">Generate Invoice</button>
  			<div class="clear_fix"></div>
		    <div class="card" id="print_area">
		        <div class="card-header p-4">
		        	<img src="<?=base_url()?>assets/images/dummy-logo" class="logo">
		            <div class="float-right">

		                <h3 class="mb-0">Invoice #<?=time()?></h3>
		                Date: <?=date('d M, Y')?>
		            </div>
		        </div>
		        <div class="card-body">
		            
		            <button class="btn btn-primary pull-right printHide" id="add_new" style="margin-bottom:10px;"><i class="fa fa-plus "></i> Add Item</button>
		            <br>
		            <div class="table-responsive-sm">
		                <table class="table table-striped" id="invoice_items">
		                    <thead>
		                        <tr>
		                            <th>Name</th>
		                            <th class="center">Quantity</th>
		                            <th class="right">Unit Price</th>
		                            <th class="center">Tax</th>
		                            <th class="right">Total</th>
		                            <th class="printHide"></th>
		                        </tr>
		                    </thead>
		                    <tbody>
		                        <tr data-row="1">
		                            <td class="left strong"><input type="text" name="product" id="product_1" class="product form-control"></td>
		                            <td class="left"><input type="number" name="qty" id="qty_1" class="qty form-control" onkeypress="return restrictInput(this, event, digitsOnly);" min="0"></td>
		                            <td class="right"><input type="number" name="price" id="price_1" onkeypress="return restrictInput(this, event, integerOnly);"  min="0" class="price form-control"></td>
		                            <td class="center">
		                            	<select name="tax" id="tax_1" class="tax form-control">
		                            		<option value="0">0%</option>
		                            		<option value="1">1%</option>
		                            		<option value="5">5%</option>
		                            		<option value="10">10%</option>
		                            	</select>
		                            </td>
		                            <td class="right"><?=CURRENCY?> <span id="line_total_1">0.00</span></td>
		                            <td class="printHide"></td>
		                        </tr>		                        
		                    </tbody>
		                </table>
		            </div>
		            <div class="row">
		                <div class="col-lg-4 col-sm-5">
		                </div>
		                <div class="col-lg-6 col-sm-5 ml-auto">
		                    <table class="table table-clear">
		                        <tbody>
		                            <tr>
		                                <td class="left">
		                                    <strong class="text-dark">Subtotal</strong>
		                                </td>
		                                <td class="right"><?=CURRENCY?> <span id="sub_total">0.00</span></td>
		                            </tr>
		                            <tr>
		                                <td class="left">
		                                    <strong class="text-dark">
		                                    	<div class="input-group col-10" id="discount_area">
												  	<input class="form-control" id="discount" name="discount" placeholder="Discount" type="number" onkeypress="return restrictInput(this, event, integerOnly);" min="0">
												  	<div class="input-group-addon currency-addon">
													    <select class="currency-selector form-control" name="discount_type" id="discount_type">
													      <option value="1">%</option>
													      <option value="2">$</option>												         
													    </select>
												  	</div>
												</div>
		                                </td>
		                                <td class="right"><?=CURRENCY?> <span id="discount_amount">0.00</span></td>
		                            </tr>
		                            <tr>
		                                <td class="left">
		                                    <strong class="text-dark">Subtotal Inc. Tax</strong>
		                                </td>
		                                <td class="right"><?=CURRENCY?> <span id="sub_total_tax">0.00</span></td>
		                            </tr>
		                            <tr style="background-color: #d7d7d7;">
		                                <td class="left">
		                                    <strong class="text-dark">Grand Total</strong> </td>
		                                <td class="right">
		                                    <strong class="text-dark"><?=CURRENCY?> <span id="grand_total">0.00</span></strong>
		                                </td>
		                            </tr>
		                        </tbody>
		                    </table>
		                </div>
		            </div>
		        </div>
		       
		    </div>
		</div>
  	</div>    
</div>

</body>
</html>
<script type="text/javascript">
$(document).ready(function(){
	$("#add_new").click(function(){
		row_count 	= ($(".product").length)+1;
		html 		= 	`<tr data-row="${row_count}">
		        	        <td class="left strong"><input type="text" name="product" id="product_${row_count}" 	class="product form-control"></td>
		        	        <td class="left"><input type="number" name="qty" id="qty_${row_count}" class="qty form-control" onkeypress="return restrictInput(this, event, digitsOnly);" min="0"></td>
		        	        <td class="right"><input type="number" name="price" id="price_${row_count}" class="price form-control" onkeypress="return restrictInput(this, event, integerOnly);" min="0"></td>
		        	        <td class="center">
		        	        	<select name="tax" id="tax_${row_count}" class="tax form-control">
		        	        		<option value="0">0%</option>
		        	        		<option value="1">1%</option>
		        	        		<option value="5">5%</option>
		        	        		<option value="10">10%</option>
		        	        	</select>
		        	        </td>
		        	        <td class="right">$ <span id="line_total_${row_count}">0.00</span></td>
		        	        <td class="printHide"><a href="javascript:" class="remove_item"><i class="fa fa-minus-circle remove_icon"></i></a></td>
		        	    </tr>`;

		$('#invoice_items').append(html);
	});

	$("body").delegate(".price , .qty , #discount", "keyup", function(){
		invoice_calculation();
	});

	$("body").delegate(".tax , #discount_type", "change", function(){
		invoice_calculation();
	});

	$("body").delegate(".remove_item", "click", function(){
		
		$(this).parent().parent().remove();
		invoice_calculation();
	});

	function invoice_calculation()
	{
		row_count 			= $(".product").length;
		var sub_total 		= 0;
		var total_tax 		= 0;
		var discount 		= $("#discount").val();
		var discount_type 	= $("#discount_type").val();
		var discount_amount	= 0;
		var sub_total_tax  	= 0;
		var grand_total 	= 0;

		for(i = 1; i <= row_count ; i++)
		{
			line_total 		= 0;
			line_tax 		= 0;
			line_sub_total 	= 0;

			qty 			= $("#qty_"+i).val();
			price 			= $("#price_"+i).val();
			tax 			= $("#tax_"+i).val();

			if(qty !="" && price != "")
			{
				line_sub_total 	= parseFloat(qty) * parseFloat(price);
				if(parseInt(tax) > 0)
				{
					line_tax 	= ( line_sub_total * tax ) / 100;
					if(isNaN(line_tax))
					{
						line_tax= 0;
					}
				}

				line_total 		= line_sub_total + line_tax;

				if(!isNaN(line_total))
					$("#line_total_"+i).html(line_total.toFixed(2));
				else
					$("#line_total_"+i).html("0.00");

				sub_total 		+= line_sub_total;
				total_tax		+= line_tax;
			}
		}
		if(!isNaN(sub_total) && !isNaN(total_tax))
		{
			if(discount !="" && discount_type !="")
			{
				if(discount_type == 1)
				{
					discount_amount 	= (sub_total * discount)/100;
				}
				else
				{
					discount_amount 	= parseFloat(discount);
				}
			}
			sub_total_tax	= parseFloat(sub_total) - parseFloat(discount_amount) + parseFloat(total_tax);
			grand_total 	= parseFloat(sub_total) - parseFloat(discount_amount) + parseFloat(total_tax);

			$("#sub_total").html(sub_total.toFixed(2));
			$("#sub_total_tax").html(sub_total_tax.toFixed(2));
			$("#discount_amount").html(discount_amount.toFixed(2));
			$("#grand_total").html(grand_total.toFixed(2));
		}
		else
		{
			$("#sub_total").html("0.00");
			$("#sub_total_tax").html("0.00");
		}
		
	}
});
$("body").delegate("#print_invoice", "click", function(){
    
    var error 	= 1;
    $(".product").each(function(){
    	if($(this).val() != "")
    	{
    		error 	= 0;
    	}
    });

    if(error == 0)
    {
	    $(".printHide").remove();
	    
	    $("#invoice_items input").each(function(){
	    	$(this).parent().html($(this).val());
	    });
	    if(!isNaN(parseFloat($("#discount").val())))
	    {
	    	discount 		= $("#discount").val();
	    }
	    else
	    {
	    	discount 		= 0;
	    }
		var discount_type 	= $("#discount_type").find(":selected").text();
	    $("#discount_area").html("Discount ("+discount+" "+discount_type+" )");
	    var printcontent = document.getElementById("print_area").innerHTML;
	    document.body.innerHTML = printcontent;
	    window.print();
	    window.location = "<?=base_url()?>";
	}
	else
	{
		alert("Please add atleast one item !");
	}
});
</script>