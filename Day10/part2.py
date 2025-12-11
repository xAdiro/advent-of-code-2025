def part2():
    with open("input.txt", "r") as f:
        file = f.read().splitlines()

    lines = [line.split(" ") for line in file]

    buttons_lines = [[[int(y) for y in x[1:-1].split(",")]
                      for x in line[1:-1]] for line in lines]
    joltages_lines = [tuple(int(x) for x in line[-1][1:-1].split(","))
                      for line in lines]

    score = 0
    row_i = 1
    total_rows = len(joltages_lines)
    for buttons, joltages in zip(buttons_lines, joltages_lines):
        print(f"{row_i}/{total_rows} - {row_i/total_rows * 100}%")
        score += fewest_clicks_iter(joltages, sorted(buttons, key=sum, reverse=True))
        row_i += 1

    print(score)


def fewest_clicks_iter(joltages, buttons):
    already_checked: dict[tuple, int] = dict()  # value, iteration
    to_check = [((0,) * len(joltages), 0)]  # value, iteration
    steps = float("inf")

    while len(to_check) > 0:
        state, iteration = to_check.pop(-1)

        if state == joltages:
            if iteration < steps:
                steps = iteration
            continue

        if not all(x <= j for x, j in zip(state, joltages)):
            continue

        if (checked := already_checked.get(state)) is not None:
            if iteration >= checked:
                continue

        already_checked[state] = iteration

        for button in buttons:
            to_check.append((click_button(state, button), iteration+1))

    return steps

    raise Exception("Can't find path")


def click_button(jolts, button):
    return tuple(jolt if i not in button else jolt+1
                 for i, jolt in enumerate(jolts))


# def fewest_clicks(start: tuple[int], end: list[int], buttons: list[list[int]], steps_already=0) -> int:
#
#     global cached
#
#     cache = cached.get(start, None)
#     if cache is not None:
#         steps, value = cache
#         if value is None:
#             if steps > steps_already:
#                 cached[start] = (steps, None)
#             else:
#                 return float("-inf")
#
#     if start == end:
#         cached[start] = (steps_already, 0)
#         return 0
#
#     for x, b in zip(start, end):
#         if x > b:
#             cached[start] = float('inf')
#             return float('inf')
#
#     paths = [tuple(x if i not in button else x+1 for i,
#                    x in enumerate(start)) for button in buttons]
#
#     best = min([fewest_clicks(path, end, buttons) for path in paths])
#
#     cached[start] = best
#     return best
#
#
if __name__ == '__main__':
    part2()
