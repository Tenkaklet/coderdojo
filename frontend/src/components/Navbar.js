import React, { useState, Fragment } from 'react'
import logo from '../img/logo.png';
import { Link } from 'react-scroll/modules'
import {FaBars, FaTimes} from 'react-icons/fa';
import {GoGlobe} from 'react-icons/go';
import {Menu, Transition} from '@headlessui/react'
import {AiOutlineCheck} from 'react-icons/ai'

function classNames(...classes) {
    return classes.filter(Boolean).join(' ')
  }

const Navbar = () => {
  const [nav, setNav] = useState(false);
  const handleClick = () => setNav(!nav);

//   const [activeNav, setActiveNav] = useState('#');
//   onClick={() => {setActiveNav('#about')}}
//   activeNav === '#about' ? 'active' : '

  return (
    <div className='z-20 fixed w-full h-[80px] flex justify-between items-center px-4 bg-white text-black'>
        <div className='flex flex-row items-center '>
            <Link className='flex cursor-pointer' to='home' smooth={true} duration={500} >
            <img src={logo} alt="Logo" style={{width: '40px', height: '40px'}} />
            <h1 className='mx-3 text-xl flex items-center font-semibold uppercase logo'>Coderdojo Helsingborg</h1>
            </Link>
        </div>
        <ul className='hidden md:flex text-lg font-semibold items-center uppercase nav-list'>
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
                <li>
                <Link to="contact" smooth={true} duration={500}>
                        Contact
                    </Link>
                </li>
                <li>
                <Link to="language" smooth={true} duration={500} className='text-[black]'>
                <Menu as="div" className="relative inline-block text-left">
      <div>
        <Menu.Button className="border-2 border-black p-1 px-5 rounded-[50px] hover:bg-slate-100">
          English
        </Menu.Button>
      </div>

      <Transition
        as={Fragment}
        enter="transition ease-out duration-100"
        enterFrom="transform opacity-0 scale-95"
        enterTo="transform opacity-100 scale-100"
        leave="transition ease-in duration-75"
        leaveFrom="transform opacity-100 scale-100"
        leaveTo="transform opacity-0 scale-95"
      >
        <Menu.Items className="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg shadow-gray-500 bg-[white] ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 focus:outline-none">
          <div className="py-1">
            <Menu.Item>
              {({ active }) => (
                <a
                  href="#"
                  className={classNames(
                    active ? 'bg-slate-100 text-black' : 'text-black',
                    'px-4 py-2 text-sm flex'
                  )}
                >
                  English <AiOutlineCheck className='text-lg ml-2'/> 
                </a>
              )}
            </Menu.Item>
            <Menu.Item>
              {({ active }) => (
                <a
                  href="#"
                  className={classNames(
                    active ? 'bg-slate-100 text-black' : 'text-black',
                    ' px-4 py-2 text-sm flex'
                  )}
                >
                  Swedish
                </a>
              )}
            </Menu.Item>
            <Menu.Item>
              {({ active }) => (
                <a
                  href="#"
                  className={classNames(
                    active ? 'bg-slate-100 text-black' : 'text-black',
                    'flex px-4 py-2 text-sm'
                  )}
                >
                  Ukrainian
                </a>
              )}
            </Menu.Item>
            <Menu.Item>
              {({ active }) => (
                <a
                  href="#"
                  className={classNames(
                    active ? 'bg-slate-100 text-black' : 'text-black',
                    'flex px-4 py-2 text-sm'
                  )}
                >
                  Arabic
                </a>
              )}
            </Menu.Item>
          </div>
          <div className="py-1">
            <Menu.Item>
              {({ active }) => (
                <a
                  href="#"
                  className={classNames(
                    active ? 'bg-slate-100 text-black' : 'text-black',
                    'flex px-4 py-2 text-sm'
                  )}
                >
                    <Link to="/languages">
                  All Languages
                  </Link>
                </a>
              )}
            </Menu.Item>
            </div>
        </Menu.Items>
      </Transition>
    </Menu>
                    </Link>
                </li>
            </ul>

             {/* hamburger  */}
        <div onClick={handleClick} className='md:hidden z-10'>
            {!nav ? <FaBars /> : <FaTimes />}
        </div>

        {/* mobile menu */}
        <ul className={!nav ? 'hidden' : 'absolute top-0 left-0 w-full h-screen bg-[white] flex flex-col justify-center items-center py-6 text-4xl'}>
            <li className="py-6 text-4xl">
                <Link onClick={handleClick} to="/home" smooth={true} duration={500}>
                        Home
                    </Link></li>
            <li className="py-6 text-4xl">
                <Link onClick={handleClick} to="/about" smooth={true} duration={500}>
                        About
                    </Link></li>
            <li className="py-6 text-4xl">
                <Link onClick={handleClick} to="/contact" smooth={true} duration={500}>
                        Contact
                    </Link></li>
            <li className="py-6 text-4xl">
                <Link onClick={handleClick} to="/languages" smooth={true} duration={500}>
                  <button className="border-2 border-black p-2 px-5 rounded-[50px] hover:bg-slate-200">Language</button>
                    
                    </Link></li>
        </ul>
    </div>
  )
}

export default Navbar