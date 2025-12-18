<?php
namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Exceptions\PageNotFoundException; // Esta no es estrictamente necesaria aquí, pero la mantengo

class Users extends BaseController
{
    /**
     * Muestra el formulario de inicio de sesión.
     * @param string|null $error Indica si debe mostrar un mensaje de error.
     */
    public function loginForm($error = null)
    {
        helper('form');
        
        // Define el mensaje de error para pasarlo a la vista
        $errorMessage = ($error === null) ? '' : 'Credenciales Incorrectas';

        // Corregido typo en 'Acces' a 'Access'
        return view('templates/header', ['title' => 'Private Access'])
            . view('users/login', ['error' => $errorMessage])
            . view('templates/footer');
    }

    /**
     * Procesa los datos del formulario de inicio de sesión y verifica el usuario.
     */
    public function checkUser()
    {
        helper('form');
        
        // 1. Validar las reglas del formulario
        if (! $this->validate([
            'username' => 'required|max_length[255]|min_length[4]',
            'password' => 'required|max_length[5000]|min_length[4]',
        ])) {
            // Si la validación falla, se vuelve a mostrar el formulario.
            // La vista de login debe tener validation_list_errors() para mostrar los mensajes.
            return $this->loginForm();
        }

        // 2. CAPTURAR DATOS del formulario POST (¡La corrección crucial!)
        // NO se debe llamar a $this->loginForm(); para obtener los datos. 
        // Se usa $this->request->getPost('campo').
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $model = model(UserModel::class);

        // 3. Verificar usuario en el modelo
        $user = $model->checkUser($username, $password);

        if ($user) {
            // Usuario autenticado correctamente

            // Obtener la instancia de la sesión (CORRECCIÓN: Se usa la función global 'session()')
            $session = session(); 
            
            // Establecer datos en la sesión
            $session->set('user', $username);
            // También puedes guardar el ID del usuario u otros datos relevantes
            $session->set('isLoggedIn', true);
            
            // Pasar los datos del usuario a la vista de administración
            $data['user'] = $user; 
            
            return view('templates/header', ['title' => 'Admin'])
                . view('users/admin', $data)
                . view('templates/footer');
        } else {
            // Autenticación fallida, volver al formulario con mensaje de error
            return $this->loginForm("Error");
        }
    }

    /**
     * Cierra la sesión del usuario.
     */
    public function closeSession()
    {
        $session = session();

        // Para cerrar la sesión de forma limpia, es mejor usar la función de invalidación.
        // session()->remove() solo quita una clave, session()->destroy() mata toda la sesión.
        $session->destroy();

        // Normalmente, después de cerrar sesión, se redirige al inicio o al login.
        return redirect()->to(base_url('ruta_a_tu_inicio_o_login'));
        // Si quieres volver a mostrar una vista estática, usa la línea original:
        // return view('welcome_message'); 
    }
}