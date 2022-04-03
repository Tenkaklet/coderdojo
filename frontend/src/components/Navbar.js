import React from 'react'
import logo from '../img/logo.png';

const Navbar = () => {
  return (
    <div className='navbar'>
        <div>
            <img src={logo} alt="Logo" style={{width: '50px', height: '40px'}} />
        </div>
        <h1>Coder<span className='dojo'>Dojo</span> Helsingborg</h1>
        </div>
  )
}

export default Navbar