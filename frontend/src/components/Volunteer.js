import React from 'react'
import vol from '../img/vol1.jpg'

const Volunteer = () => {
  return (
    <div className='w-full h-[700px] bg-white text-black relative top-[80px]'>
      <div className='vol-container h-full w-full lg:w-[1300px] lg:m-auto flex justify-center items-center '>
       <img src={vol} className='rounded-md lg:w-[500px] lg:h-[500px] md:block hidden ml-20 w-[300px] h-[400px]' />
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
            Volunteering at the CoderDojo Helsingborg is one of the most inspiring workplaces that I work at. I help young coders become tomorrows pioneers! With the help of games or even simple to complex programs in various different programming languages, they develop skills that are not only fun and engaging but also captivating and educational. 
            </p>
            <p className='pt-5 text-[#444]'>Seeing the kids learn with the help of each other is also really fun. They really like to help each other even if they don't know the programming language!</p>
            <p className='font-bold pt-10'>Max Carlquist - Helsingborg, Sweden</p>
        </div>
        </div>
    </div>
  )
}

export default Volunteer