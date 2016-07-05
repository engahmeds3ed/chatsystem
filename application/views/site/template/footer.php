      </div><!-- #fullcontainer -->
      
      <footer>
        <div class="text-center">
            Eng. Ahmed Saed
        </div>
        
      </footer>
      <script type="text/javascript" src="<?php echo $this->assets; ?>js/jquery.js"></script>
      <script type="text/javascript" src="<?php echo $this->assets; ?>js/bootstrap.min.js"></script>
      <script type="text/javascript" src="<?php echo $this->assets; ?>js/scripts.js"></script>
      
      <?php
        if(!empty($scripts) && is_array($scripts) && isset($scripts)){
            foreach($scripts as $script){
                ?>
                <script type="text/javascript" src="<?php echo $this->assets; ?>js/<?php echo $script; ?>"></script>
                <?php
            }
        }
      ?>
      
   </body>
</html>