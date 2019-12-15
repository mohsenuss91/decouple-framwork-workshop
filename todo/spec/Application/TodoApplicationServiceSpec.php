<?php

namespace spec\Todo\Application;

use PhpSpec\ObjectBehavior;
use Todo\Application\TodoService;
use Todo\Domain\Model\Todo\TodoList;
use Todo\Domain\Model\Todo\Todo;
use Todo\Domain\Model\Todo\TodoName;
use Todo\Domain\Model\Todo\Owner;
use Todo\Domain\Model\Todo\OwnerService;
use Todo\Domain\Model\Todo\TodoDeadline;
use Todo\Domain\Model\Todo\TodoReminder;

class TodoApplicationServiceSpec extends ObjectBehavior
{
    function it_adds_todo(TodoList $todoList, OwnerService $ownerService)
    {
        $owner = Owner::from('an-id', 'cherif@site.com', 'cherif_b');
        $todo = Todo::add(TodoName::fromString('Learn TDD'), $owner);
        $ownerService->get('an-id')->willReturn($owner);
        $this->beConstructedWith($todoList, $ownerService);
        $this->addTodo('Learn TDD', 'an-id');
        $todoList->save($todo)->shouldHaveBeenCalled();
    }

    function it_marks_todo_as_done(TodoList $todoList, OwnerService $ownerService)
    {
        $todo = Todo::add(TodoName::fromString('Learn TDD'), Owner::from('an-id', 'cherif@site.com', 'cherif_b'));
        $todoList->getTodoByName($todo->getName())->willReturn($todo);
        $todoList->save($todo)->shouldBeCalled();
        $this->beConstructedWith($todoList, $ownerService);
        $this->markTodoAsDone('Learn TDD');
        $todoList->getTodoByName($todo->getName())->shouldHaveBeenCalled();
        $todoList->save($todo)->shouldHaveBeenCalled();
    }

    function it_reopens_a_done_todo(TodoList $todoList, OwnerService $ownerService)
    {
        $todo = Todo::add(TodoName::fromString('Learn TDD'), Owner::from('an-id', 'cherif@site.com', 'cherif_b'));
        $todo->markAsDone();
        $todoList->getTodoByName($todo->getName())->willReturn($todo);
        $todoList->save($todo)->shouldBeCalled();
        $this->beConstructedWith($todoList, $ownerService);
        $this->reopenTodo('Learn TDD');
        $todoList->getTodoByName($todo->getName())->shouldHaveBeenCalled();
    }

    function it_adds_deadline_to_todo(TodoList $todoList, OwnerService $ownerService)
    {
        $deadline = TodoDeadline::fromString('2020-01-05');
        $owner = Owner::from('an-id', 'cherif@site.com', 'cherif_b');
        $todo = Todo::add(TodoName::fromString('Learn TDD'), $owner);
        $todoList->getTodoByName($todo->getName())->shouldBeCalled();
        $todoList->getTodoByName($todo->getName())->willReturn($todo);
        $ownerService->get('an-id')->shouldBeCalled();
        $ownerService->get('an-id')->willReturn($owner);
        $todoList->save($todo)->shouldBeCalled();
        $this->beConstructedWith($todoList, $ownerService);
        $this->addDeadLineToTodo('Learn TDD' ,'2020-01-05', 'an-id');
    }

    function it_adds_reminder_to_todo(TodoList $todoList, OwnerService $ownerService)
    {
        $reminder = TodoReminder::fromString('2020-01-05');
        $owner = Owner::from('an-id', 'cherif@site.com', 'cherif_b');
        $todo = Todo::add(TodoName::fromString('Learn TDD'), $owner);
        $todoList->getTodoByName($todo->getName())->shouldBeCalled();
        $todoList->getTodoByName($todo->getName())->willReturn($todo);
        $ownerService->get('an-id')->shouldBeCalled();
        $ownerService->get('an-id')->willReturn($owner);
        $todoList->save($todo)->shouldBeCalled();
        $this->beConstructedWith($todoList, $ownerService);
        $this->addReminderToTodo('Learn TDD' ,'2020-01-02', 'an-id');
    }
}