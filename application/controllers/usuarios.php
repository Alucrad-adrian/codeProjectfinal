<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios extends CI_Controller {

	public function index()
	{
		$this->load->view('inc/head');
		$this->load->view('loginform');
		$this->load->view('inc/footer');
		$this->load->view('inc/pie');
	}

	public function validarusuario()
	{
		$login=$_POST['login'];
		$password=md5($_POST['password']);

		echo $login;
		echo $password;
		$consulta=$this->usuario_model->validar($login,$password);

		echo $consulta->num_rows();

		if($consulta->num_rows()>0)
		{
			echo 'inicio de sesion';
			//usuario valido
			foreach($consulta->result() as $row)
			{

				$this->session->set_userdata('idusuario',$row->idUsuario);
				$this->session->set_userdata('login',$row->login);
				$this->session->set_userdata('tipo',$row->tipo);

				redirect('usuarios/panel','refresh');
			}
		}
		else
		{
			//acceso incorrecto - volvemos al login
			redirect('usuarios/index','refresh');
		}
	}

	public function panel()
	{
		if($this->session->userdata('login'))
		{
			redirect('estudiante/curso','refresh');
		}
		else
		{
			redirect('usuarios/index','refresh');
		}
	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect('usuarios/index','refresh');
	}

}
