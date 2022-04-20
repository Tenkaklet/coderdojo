import React from 'react'
import vol from '../img/ninja.svg'

const Volunteer = () => {
  return (
    <div className='w-full h-[700px] bg-white text-black relative top-[80px]'>
      <div className='vol-container h-full w-full lg:w-[1300px] lg:m-auto flex justify-center items-center '>
       <img src={vol} className='lg:w-[500px] lg:h-[500px] md:block hidden ml-20 w-[300px] h-[300px]' />
        <div className='flex justify-center flex-col ml-10 mr-10 h-full lg:mx-20'>
            <div className='font-bold'>
            <h2 className='text-4xl'>
            Volunteer at a Dojo
            </h2>
            <h4 className='text-xl'>
            Join us and meet 12,000 like-minded volunteers
            </h4>
            </div>
            <p className='pt-10 text-[#444]'>
            Whether or not you can code, you can help a local club in just a few hours a month! Dojos need general volunteers, and mentors for sessions. Even mentors don’t have to have technical skills, because they help the young people mainly by encouraging them to discover their own way forward. 
            </p>
            <p className='pt-5 text-[#444]'>When I see them doing things on their own, getting their ideas out there, and seeing creativity spur out of the moment, really gives me so much joy.</p>
            <p className='font-bold pt-10'>Max, Dojo volunteer in Sweden</p>
        </div>
        </div>
    </div>
  )
}

export default Volunteer