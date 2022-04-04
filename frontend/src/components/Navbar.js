import React, { useState } from 'react'
import logo from '../img/logo.png';
import { Link } from 'react-scroll/modules'
import {FaBars, FaTimes, FaLinkedin, FaGithub} from 'react-icons/fa';

const Navbar = () => {
  const [nav, setNav] = useState(false);
  const handleClick = () => setNav(!nav);

  return (
    <div className='fixed w-full h-[80px] flex justify-between items-center px-4 bg-[#AE0B05] text-white'>
        <div className='flex flex-row items-center '>
            <img src={logo} alt="Logo" style={{width: '40px', height: '40px'}} />
            <h1 className='mx-2'>Coder<span className='text-black'>Dojo</span> Helsingborg</h1>
        </div>
        <ul className='hidden md:flex text-xl'>
                <li>
                    <Link to="home" smooth={true} duration={500}>
                        Home
                    </Link>
                </li>
                <li>
                <Link to="about" smooth={true} duration={500}>
                        About
                    </Link>
                </li>
                {/* <li>
                <Link to="language" smooth={true} duration={500}>
                        Language
                    </Link>
                </li> */}
                <li>
                <Link to="work" smooth={true} duration={500}>
                        Language
                    </Link>
                </li>
                <li>
                <Link to="contact" smooth={true} duration={500}>
                        Contact
                    </Link>
                </li>
            </ul>

             {/* hamburger  */}
        <div onClick={handleClick} className='md:hidden z-10'>
            {!nav ? <FaBars /> : <FaTimes />}
        </div>

        {/* mobile menu */}
        <ul className={!nav ? 'hidden' : 'absolute top-0 left-0 w-full h-screen bg-[#AE0B05] flex flex-col justify-center items-center py-6 text-4xl'}>
            <li className="py-6 text-4xl">
                <Link onClick={handleClick} to="home" smooth={true} duration={500}>
                        Home
                    </Link></li>
            <li className="py-6 text-4xl">
                <Link onClick={handleClick} to="about" smooth={true} duration={500}>
                        About
                    </Link></li>
            <li className="py-6 text-4xl">
                <Link onClick={handleClick} to="skills" smooth={true} duration={500}>
                        Language
                    </Link></li>
            <li className="py-6 text-4xl">
                <Link onClick={handleClick} to="contact" smooth={true} duration={500}>
                        Contact
                    </Link></li>
        </ul>
    </div>
  )
}

export default Navbar