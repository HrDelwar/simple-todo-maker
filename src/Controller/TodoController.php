<?php

namespace Hr\WpSTM\Controller;

use Hr\WpSTM\Model\TodoModel;

class TodoController {
	protected $model;

	public function __construct() {
		$this->model = new TodoModel();

		add_action( 'wp_ajax_wpstm_create_todo', [ $this, 'wpstm_create_todo' ] );
		add_action( 'wp_ajax_nopriv_wpstm_create_todo', [ $this, 'wpstm_create_todo' ] );
	}


	public function wpstm_create_todo() {

		if ( ! wp_verify_nonce( $_REQUEST['nonce'], WPSTM_NONCE ) ) {
			wp_send_json( array(
				'status'  => false,
				'message' => 'Something wrong! Not a valid request.',
			) );
			wp_die();
		}
		$todo_name = isset( $_POST['todo_name'] ) ? $_POST['todo_name'] : '';
		if ( isset( $todo_name ) && ! empty( $todo_name ) ) {
			$data = array(
				'todo_name' => $todo_name,
			);


			$result = $this->model->store( $data );
			if ( $result ) {
				wp_send_json( array(
					'status'  => true,
					'message' => 'Todo create successfully!',
					'id'      => $result
				) );

			} else {
				wp_send_json( array(
					'status'  => false,
					'message' => 'Something went wrong! Please try again latter.'
				) );
			}

		}


	}

	public function wpstm_get_all_todo() {
		if ( ! wp_verify_nonce( $_REQUEST['nonce'], WPSTM_NONCE ) ) {
			wp_send_json( array(
				'status'  => false,
				'message' => 'Something wrong! Not a valid request.',
			) );
			wp_die();
		}
		$data = $this->model->getAll();
		if ( count( $data ) > 0 ) {
			wp_send_json( array(
				'status'  => true,
				'message' => 'Total todo found : ' . count( $data ),
				'todos'   => $data
			) );
		} else {
			wp_send_json( array(
				'status'  => false,
				'message' => 'Todo not found.',
				'todos'   => []
			) );
		}
		wp_die();
	}

	public function wpstm_change_todo_status() {
		if ( ! wp_verify_nonce( $_REQUEST['nonce'], WPSTM_NONCE ) ) {
			wp_send_json( array(
				'status'  => false,
				'message' => 'Something wrong! Not a valid request.',
			) );
			wp_die();
		}
		$id = $_REQUEST['id'];
		if ( isset( $id ) && ! empty( $id ) ) {
			$row            = $this->model->find( $id );
			$status         = $row->completed;
			$row->completed = $row->completed === '0' ? 1 : 0;
			$this->model->update( (array) $row, $id );
			if ( $status === $row->completed ) {
				wp_send_json( array(
					'status'    => false,
					'message'   => 'Something went wrong! Please try again latter.',
					'completed' => $status
				) );
			} else {
				wp_send_json( array(
					'status'    => true,
					'message'   => 'Status change successfully!',
					'completed' => $row->completed
				) );
			}
		} else {
			wp_send_json( array(
				'status'  => false,
				'message' => 'Id is required or not should be empty.',
			) );
			wp_die();
		}
	}

	public function wpstm_delete_todo() {
		if ( ! wp_verify_nonce( $_REQUEST['nonce'], WPSTM_NONCE ) ) {
			wp_send_json( array(
				'status'  => false,
				'message' => 'Something wrong! Not a valid request.',
			) );
			wp_die();
		}
		$id = $_REQUEST['id'];
		if ( isset( $id ) && ! empty( $id ) ) {
			if ( $this->model->destroy( $id ) ) {
				wp_send_json( array(
					'status'  => true,
					'message' => 'Delete successfully!'
				) );
			} else {
				wp_send_json( array(
					'status'  => false,
					'message' => 'Something wrong! Try again later.'
				) );
			}
		} else {
			wp_send_json( array(
				'status'  => false,
				'message' => 'Id is required or not should be empty.',
			) );
			wp_die();
		}
		wp_die();
	}
}