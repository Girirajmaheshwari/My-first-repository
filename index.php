<?php

/**
 * @file
 */

function callcustomfn_delay() {
    sleep(10);
    drupal_goto();
  }
/**
 * Implements hook_form_alter().
 */
function custom_form_alter(&$form, $form_state, $form_id) {

  switch ($form_id) {
    case 'page_node_form':
      if(!empty($form['#node']->nid)){  
        //callcustomfn_delay();
        $form['title'] = array(
          '#type' => 'textfield',
          '#title' => t('Title'),
          '#default_value' => $form['#node']->title ,
          '#ajax' => array(
            'callback' => 'updatefield_ajax',
            'event' => 'blur',
            'wrapper' => 'message_div',
            'method' => 'replace',
            'effect' => 'fade',
          ), 
          '#weight' => 1,
          '#required' => TRUE,
           '#prefix' => '<div id="message_div">',
           '#suffix' => '</div>',
        );
       
        
        $form['actions']['submit'] = array(
          '#type' => 'submit',
          '#value' => t('Submit'),
          '#ajax' => array(
            'callback' => 'updateformdata',
            'event' => 'click',
            'wrapper' => '',
            'method' => 'replace',
            'effect' => 'fade',
          ),
        );
        
       } 
  }
}

function updatefield_ajax($form, &$form_state) {
 /* 
   // Method 1
 $nid = $form['#node']->nid;
  $node = node_load($nid); 
  if(!empty($form_state['values']['title'])){
      $node->title = $form_state['values']['title'];
      $node = node_submit($node); // Prepare node for a submit
      node_save($node);
  }else{
      form_set_error('title', $message = 'title fileld could not be blank', $reset = FALSE);
  } */
  
  // Method 2
  
  $form['#node']->title = $form_state['values']['title'];
 if(!empty($form_state['values']['title'])){
  if (node_save($form['#node'])) {
    drupal_set_message('Updated the node title.');
  } else {
    drupal_set_message('Could not update the node title.', 'error');
  }
 } 
}


function updateformdata($form, &$form_state) { 
  
  $form['#node']->title = $form_state['values']['title'];
  $form['#node']->body = $form_state['values']['body'];
  
  if(node_save($form['#node'])) {
    drupal_set_message('Updated the node title.');
  } else {
    drupal_set_message('Could not update the node title.', 'error');
  }
 
}
