<li id="<?php echo $this->_row->id;?>" class="<?php echo $this->_row->class;?>">
	<?php foreach ($this->headings as $heading=>$label) {	?>
		<span class="<?php echo $this->cellClass[$heading]['class']?>">
			<?php echo @$this->_row->data->$heading;?>
		</span>
	<?php }?>
</li>