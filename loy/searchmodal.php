<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">
        <?php 

            switch($_GET['flag']){
            case "loy_points_history":
                echo "Hot Offer History";
                break;
            case "stock":
                echo "Stock History Last 60 Days";
                break;
            default:
                echo "Products";
                break;
            
            }   

        ?>
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
      <?php 

      switch($_GET['flag']){
        case "loy_points_history":
            echo multi_products(get_trend("loy_points_history",$_GET['text_sku_search']),"loy_points_history"); 
            break;
        case "results":
            echo multi_products(get_trend("results",$_GET['text_sku_search'],$last_date),"results"); 
            break;
        case "stock":
            echo multi_products(get_trend("stocks",$_GET['text_sku_search']),"stocks"); 
            break;
          
        }
        //echo num_results($_GET['text_sku_search']);
      ?>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        
      </div>
    </div>
  </div>
</div>