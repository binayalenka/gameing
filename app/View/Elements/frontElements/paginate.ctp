<ul class="pagination">
		<?php echo $this->Paginator->prev('<< '.__('Previous', true), array(), null, array('title'=>'Previous Page','class' => 'no-display'));?>
	
	
		<?php echo $this->Paginator->next(__('Next', true).' >>', array(), null, array('title' => 'Next Page','class' => 'no-display'));?>		
</ul>			