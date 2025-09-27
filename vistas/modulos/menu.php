<aside class="main-sidebar">

	 <section class="sidebar">

		<ul class="sidebar-menu">

		<?php
        // VISUALIZAR EN EL MINIBAR USUARIOS
		if($_SESSION["perfil"] == "Administrador"){

			echo '<li class="active">

				<a href="inicio">

					<i class="fa fa-home"></i>
					<span>Inicio</span>

				</a>

			</li>';

		}
		if($_SESSION["perfil"] == "Administrador" || $_SESSION["perfil"] == "Vendedor" || $_SESSION["perfil"] == "Especial"){

			echo '<li>
				<a href="mesas">

					<i class="fa fa-globe"></i>
					<span>Mesas</span>

				</a>

			</li>
			';

		}
		if($_SESSION["perfil"] == "Administrador"){

			echo '<li>

				<a href="usuarios">

					<i class="fa fa-user"></i>
					<span>Usuarios</span>

				</a>

			</li>
			
			<li>

				<a href="gastos">

					<i class="fa fa-usd"></i>
					<span>Gastos</span>

				</a>

			</li>';

		}

		if($_SESSION["perfil"] == "Administrador" || $_SESSION["perfil"] == "Especial"){

			echo '<li>

				<a href="categorias">

					<i class="fa fa-th"></i>
					<span>Categorías</span>

				</a>

			</li>

			<li>

				<a href="productos">

					<i class="fa-solid fa-landmark"></i>
					<span>Productos</span>

				</a>

			</li>';

		}

		if($_SESSION["perfil"] == "Administrador" || $_SESSION["perfil"] == "Vendedor" || $_SESSION["perfil"] == "Especial"){

			echo '<li>

				<a href="clientes">

					<i class="fa fa-users"></i>
					<span>Clientes</span>

				</a>

			</li>
			<li class="treeview">

				<a href="#">

					<i class="fa fa-list-ul"></i>
					
					<span>Ventas</span>
					
					<span class="pull-right-container">
					
						<i class="fa fa-angle-left pull-right"></i>

					</span>

				</a>

				<ul class="treeview-menu">
					
					<li>

						<a href="ventas">
							
							<i class="fa-solid fa-chart-line"></i>
							<span>Administrar ventas</span>

						</a>

					</li>
					
			            <li>

			            	<a href="ventas-por-producto">

			            		<i class="fa fa-bar-chart"></i>
			            		<span>Ventas por producto</span>

			            	</a>

			            </li>

					<li>

						<a href="crear-venta">
							
							<i class="fa-solid fa-money-bill"></i>
							<span>Crear venta</span>

						</a>

					</li>';

					if($_SESSION["perfil"] == "Administrador"){

					echo '
						<li>

			            	<a href="creditos-por-cliente">

			            		<i class="fa fa-address-book"></i>
			            		<span>Creditos por cliente</span>

			            	</a>

			            </li>
					
					<li>

						<a href="reportes">
							
							<i class="fa-solid fa-chart-simple"></i>
							<span>Reporte de ventas</span>

						</a>

					</li>';

					}

				

				echo '</ul>

			</li>';

		}

		?>

		</ul>

	 </section>

</aside>